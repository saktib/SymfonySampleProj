<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;

class AppBuyIcecreamCommand extends Command
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
        $scoopPrice = 30;
        $toppingPrice = 20;
        
        $scoopsCount =[
            '1'=>'1',
            '2'=>'2',
            '3'=>'3',
            '4'=>'4',
            '5'=>'5',
        ];
        $toppingsCount =[
            '1'=>'1',
            '2'=>'2',
            '3'=>'3',
            '4'=>'4',
            '5'=>'5',
        ];
        
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
        
        
        $output->writeln('Your have to pay: '.$totalPrice );
    }

}
