<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\EventDispatcher\EventDispatcher;
use AppBundle\Event\CreateAccountsEvent;

class AppBuyIcecreamCommand extends ContainerAwareCommand  
{
    protected function configure()
    {        
        $this
            ->setName('app:buy-icecream')
            ->setDescription('Take Icecream Order.')
            ->setHelp('This command allow for taking ice-cream order.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* Fetched shop values from config.yml*/
        $scoopPrice = $this->getContainer()->getParameter('shop.scoop_price');
        $toppingPrice = $this->getContainer()->getParameter('shop.topping_price');
        $accountPrice = $this->getContainer()->getParameter('shop.account_price');
        $scoopsCount = $this->getContainer()->getParameter('shop.scoops_count');
        $toppingsCount = $this->getContainer()->getParameter('shop.toppings_count');
        
        $helper = $this->getHelper('question');
        
        /*Scoop Options*/
            $question = new ChoiceQuestion(
                'Select number of scoops:',
                $scoopsCount
                );     
            $question->setErrorMessage('Can not exceed more than 5 scoops.'); 
            $scoops = $helper->ask($input, $output, $question);
            $scoopsTotalPrice = $scoopPrice*$scoops;
        
        /*Topping Options*/
            $question = new ChoiceQuestion(
                'Select number of toppings:',
                $toppingsCount
                );
            $question->setErrorMessage('Can not exceed more than 5 toppings.');
            $toppings = $helper->ask($input, $output, $question);
            $toppingsTotalPrice = $toppingPrice*$toppings;
        
        /*Toal Price Calculation*/
            $totalPrice = $scoopsTotalPrice+$toppingsTotalPrice;
        
        if($totalPrice > $accountPrice){
            // creates the OrderPlacedEvent and dispatches it.
            $dispatcher = new EventDispatcher();
            $event = new CreateAccountsEvent();
            $dispatcher->dispatch(CreateAccountsEvent::NAME, $event);
        }else{
            // Print the price to pay.
            $output->writeln('Your have to pay: '.$totalPrice );
        }
    }
}
