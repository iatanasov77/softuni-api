<?php namespace App\Controller\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class TablaturesController extends AbstractController
{
    /** @var EntityRepository */
    protected EntityRepository $tabsRepository;
    
    /** @var string */
    protected string $tabsDirectory;
    
    public function __construct( EntityRepository $tabsRepository, string $tabsDirectory )
    {
        $this->tabsRepository   = $tabsRepository;
        $this->tabsDirectory    = $tabsDirectory;
    }
    
    public function read( $tabId, Request $request ): Response
    {
        $oTablature     = $this->tabsRepository->find( $tabId );
        $fileTablature  = $this->tabsDirectory . '/' . $oTablature->getTablatureFile()->getPath();
        
        // open the file in a binary mode
        return new BinaryFileResponse( $fileTablature, 200, ["Content-Type" => "audio/x-guitar-pro"] );
    }
}