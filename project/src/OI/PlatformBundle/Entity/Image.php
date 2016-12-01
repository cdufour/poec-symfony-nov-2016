<?php

namespace OI\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="oi_image")
 * @ORM\Entity(repositoryClass="OI\PlatformBundle\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    private $file;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function getFile()
    {
      return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
      $this->file = $file;
    }

    public function upload()
    {
      if ($this->file === null) return;

      // récupérer le nom original du fichier soumis par le visiteur
      $name = $this->file->getClientOriginalName();

      // déplacer le fichier dans le dossier cible
      $this->file->move($this->getUploadDir(), $name);

      // enregistrement du nom du fichier dans la propriété url
      $this->url = $name;
    }

    public function getUploadDir()
    {
      // retourne le chemin relative du dossier de stockage
      return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
      // retourne le chemin absolu du dossier de stockage
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
}
