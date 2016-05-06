<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Command
 *
 * @author kiryaserg
 */
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\EventDispatcher\EventDispatcher;
use ParserBundle\Events\ParsedItemEvent;

class ParserStartCommand extends ContainerAwareCommand 
{
    protected function configure()
    {
        $this
            ->setName('parser:start')
            ->setDescription('Starts to parse data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('parser starts');
        $this->addListners();
        $parserFactory = $this->getContainer()->get('parser_factory');
       
        $em = $this->getContainer()->get('doctrine')->getManager();
        $shopRepository = $em->getRepository('AppBundle:Shop');
        while(($shop = $shopRepository->getNextShopToParse()) !== NULL){
            $output->writeln('parse: ' . $shop->getName());
            $shopRepository->updateLastImportTime($shop);
            $parser = $parserFactory->get($shop->getId());
            $parser->setShopId($shop->getId())
                ->registerOnParseCallback(array($this, 'saveConvertedItem'))
                ->parse($shop->getApiUri());
        }
        $output->writeln('parser ends');
    }
    
    public function saveConvertedItem($event){
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $orderRepository = $em->getRepository('AppBundle:Order');
        $data = $event->getData();
        $shopRepository = $em->getRepository('AppBundle:Shop');
        $shop = $shopRepository->findOneById($data['shopId']);
        $orderRepository->setShop($shop)->saveItem($event->getData());
        $shopRepository->updateLastImportTime($shop);
        $em->clear();
        gc_collect_cycles();
    }
            
    private function addListners(){
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $eventDispatcher->addListener(
            ParsedItemEvent::NAME,
            function ($event) use($em) {
                $orderRepository = $em->getRepository('AppBundle:Order');
                $data = $event->getData();
                $shopRepository = $em->getRepository('AppBundle:Shop');
                $shop = $shopRepository->findOneById($data['shopId']);
                $orderRepository->setShop($shop)->saveItem($event->getData());
                $shopRepository->updateLastImportTime($shop);
                $em->clear();
                gc_collect_cycles();
            }
        );
        
    }
    
    
    
}
