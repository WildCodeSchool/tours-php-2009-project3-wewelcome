<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HomeRepository;
use App\Entity\Home;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class HomeManager
{
    private ContainerBagInterface $params;
    private EntityManagerInterface $entityManager;
    private HomeRepository $homeRepository;
    private FileManager $fileManager;

    public function __construct(
        ContainerBagInterface $params,
        EntityManagerInterface $entityManager,
        HomeRepository $homeRepository,
        FileManager $fileManager
    ) {
        $this->params = $params;
        $this->entityManager = $entityManager;
        $this->homeRepository = $homeRepository;
        $this->fileManager = $fileManager;
    }

    public function removeDataAndFolder(Home $home, string $type, string $directory): void
    {
        $home = $this->homeRepository->findOneBy(['type' => $type]);
        //Creation of a home object if one does not exist in the database
        //Otherwise sending the home object in the view will not work
        if ($home === null) {
            $home = new Home();
        }
        //Delete photos in the home folder if there are any
        if ($home !== null) {
            //Delete photos in the home folder if there are any
            if ($home->getPictureOne() !== null) {
                $this->fileManager->deleteFile($home->getPictureOne(), $this->params->get($directory));
            }
            if ($home->getPictureTwo() !== null) {
                $this->fileManager->deleteFile($home->getPictureTwo(), $this->params->get($directory));
            }
            if ($home->getPictureThree() !== null) {
                $this->fileManager->deleteFile($home->getPictureThree(), $this->params->get($directory));
            }
        }
        //Deleting the home object from the database if not null
        if ($home !== null) {
            $this->entityManager->remove($home);
        }
        $this->entityManager->flush();
    }
}
