<?php namespace App\Entity\UserManagement;

use Doctrine\ORM\Mapping as ORM;
use Vankosoft\UsersBundle\Model\User as BaseUser;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\Tablature;

/**
 * @ORM\Entity
 * @ORM\Table(name="VSUM_Users")
 */
class User extends BaseUser
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tablature", mappedBy="user")
     */
    protected $tablatures;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tablature", inversedBy="favoriteUsers")
     * @ORM\JoinTable(name="WGP_Users_Favorites",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="favorite_id", referencedColumnName="id")}
     * )
     */
    protected $favorites;
    
    public function __construct()
    {
        $this->tablatures       = new ArrayCollection();
        $this->favorites        = new ArrayCollection();
        
        parent::__construct();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        /* Use RolesCollection */
        return $this->getRolesFromCollection();
    }
    
    /**
     * @return Collection|Tablature[]
     */
    public function getTablatures(): Collection
    {
        return $this->tablatures;
    }
    
    /**
     * @return Collection|Tablature[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }
    
    public function addFavorite( Tablature $tablature ): self
    {
        if ( ! $this->favorites->contains( $tablature ) ) {
            $this->favorites[] = $tablature;
            $tablature->addFavoriteUsers( $this );
        }
        
        return $this;
    }
    
    public function removeFavorite( Tablature $tablature ): self
    {
        if ( $this->favorites->contains( $tablature ) ) {
            $this->favorites->removeElement( $tablature );
        }
        
        return $this;
    }
}
