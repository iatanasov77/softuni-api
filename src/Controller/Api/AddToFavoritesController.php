<?php namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class AddToFavoritesController extends AbstractController
{
    /** @var TokenStorageInterface */
    private $tokenStorage;
    
    /** @var ManagerRegistry */
    private $doctrine;
    
    /** @var RepositoryInterface */
    private $tablaturesRepository;
    
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ManagerRegistry $doctrine,
        RepositoryInterface $tablaturesRepository
    ) {
        $this->tokenStorage         = $tokenStorage;
        $this->doctrine             = $doctrine;
        $this->tablaturesRepository = $tablaturesRepository;
    }
    
    public function __invoke( Request $request ): iterable
    {
        $requestBody    = \json_decode( $request->getContent(), true );
        $em             = $this->doctrine->getManager();
        $oUser          = $this->tokenStorage->getToken()->getUser();
        $oTablature     = $this->tablaturesRepository->find( $requestBody['tablatureId'] );
        
        $oUser->addFavorite( $oTablature );
        $em->persist( $oUser );
        $em->flush();
        
        return $oUser->getFavorites();
    }
}
