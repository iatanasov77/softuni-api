<?php namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;

use App\Entity\UserManagement\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="WGP_Tablatures")
 */
class Tablature implements ResourceInterface
{
    use BlameableEntity;
    use TimestampableEntity;
    use ToggleableTrait;    // About enabled field - $enabled (public)
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="artist", type="string", length=255, nullable=false)
     */
    private $artist;
    
    /**
     * @ORM\Column(name="song", type="string", length=255, nullable=false)
     */
    private $song;
    
    /**
     * @ORM\OneToOne(targetEntity=TablatureFile::class, mappedBy="owner", cascade={"persist", "remove"})
     */
    private $tablatureFile;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean", options={"default":"1"})
     */
    protected $enabled = true;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserManagement\User", inversedBy="tablatures", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserManagement\User", mappedBy="favorites", cascade={"persist"})
     */
    private $favoriteUsers;
   
    public function getId()
    {
        return $this->id; 
    }
    
    public function getTablatureFile()
    {
        return $this->tablatureFile;
    }
    
    public function setTablatureFile($tablatureFile)
    {
        $this->tablatureFile = $tablatureFile;
        
        return $this;
    }
    
    public function getArtist()
    {
        return $this->artist;
    }
    
    public function setArtist($artist)
    {
        $this->artist   = $artist;
        
        return $this;
    }
    
    public function getSong()
    {
        return $this->song;
    }
    
    public function setSong($song)
    {
        $this->song = $song;
        
        return $this;
    }
    
    public function getName()
    {
        return $this->artist . ' - ' . $this->song;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    public function addFavoriteUsers(User $user)
    {
        $this->favoriteUsers[] = $user;
    }
    
    public function getFavoriteUsers(): ?Collection
    {
        return $this->favoriteUsers;
    }
    
    
    
    
    /**
     * PROXY METHODS BELOW
     */
    
    public function isPublic(): bool
    {
        return $this->enabled;
    }
    
    public function getPublished(): bool
    {
        return $this->enabled;
    }
    
    public function getTablatureOriginalFileName() {
        return $this->tablatureFile->getOriginalName();
    }
}
