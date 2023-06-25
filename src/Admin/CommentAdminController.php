<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Request\AdminFetcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentAdminController extends CRUDController
{
    private Pool $adminPool;
    private AdminFetcherInterface $adminFetcher;

    public function __construct(Pool $adminPool, AdminFetcherInterface $adminFetcher)
    {
        $this->adminPool = $adminPool;
        $this->adminFetcher = $adminFetcher;
    }

    public function validateAction(int $id): RedirectResponse
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw $this->createNotFoundException(sprintf('Impossible de trouver le témoignage avec l\'id: %s', $id));
        }

        // Set the status of the comment to 'validated'
        $object->setStatus('validated');

        // Save the changes
        $this->admin->getModelManager()->update($object);

        // Add a flash message
        $this->addFlash('sonata_flash_success', 'Témoignage validé avec succès.');

        // Redirect to the list view
        return $this->redirectToList();
    }

    public function rejectAction(int $id): RedirectResponse
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw $this->createNotFoundException(sprintf('Impossible de trouver le témoignage avec l\'id: %s', $id));
        }

        // Set the status of the comment to 'rejected'
        $object->setStatus('rejected');

        // Save the changes
        $this->admin->getModelManager()->update($object);

        // Add a flash message
        $this->addFlash('sonata_flash_success', 'Témoignage rejeté avec succès.');

        // Redirect to the list view
        return $this->redirectToList();
    }

}
