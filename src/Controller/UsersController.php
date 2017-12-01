<?php

namespace Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Models\UsersModel;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return JsonResponse
     */
    public function getAll(Request $request, Application $app): JsonResponse
    {
        $allUsersArrayObject = $this->getEntityManager($app)
            ->getRepository(UsersModel::class)
            ->findAll();

        $result = [];
        foreach ($allUsersArrayObject as  $userObject) {
            $result[] = $userObject->toArray();
        }

        return $app->json($result);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return JsonResponse
     */
    public function createUser(Request $request, Application $app): JsonResponse
    {
        if ( !$request->query->has('lastname') || !$request->query->has('firstname') ) {
            // Si il manque un paramètre retour json
            $jsonReturn = ['code' => '0', 'message' => 'Paramètre manquant'];
        }
        else {
            // On créer un nouveau UserModel vide
            $userToStore = new UsersModel();

            // On remplie notre objet avec les valeurs dans la requests POST (Doctrine fait le striptag)
            $userToStore->setLastname($request->query->get('lastname'));
            $userToStore->setFirstname($request->query->get('firstname'));

            // On récupère notre EntityManager
            $entityManager = $this->getEntityManager($app);

            // On ajoute notre utilisateur dans la pile pour le rajouter dans la db
            $entityManager->persist($userToStore);

            // On execute les taches en attente
            $entityManager->flush();

            // On créer notre retour json
            $jsonReturn = ['code' => '1', 'message' => 'Utilisateur ajouté'];
        }

        return $app->json($jsonReturn);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return JsonResponse
     */
    public function deleteUser(Request $request, Application $app, $id): JsonResponse
    {
        // On récupère notre entityManager
        $entityManager = $this->getEntityManager($app);

        // On séléctionner notre utilisateur à suprimmer
        $userToDelete = $entityManager->find(UsersModel::class, $id);

        if ($userToDelete === null) {
            $jsonReturn = ['code' => '0', 'message' => 'Utilisateur non valide'];
        } else {
            // On met notre utilisateur à suprimmer dans la pile
            $entityManager->remove($userToDelete);

            // On lance la suppresion
            $entityManager->flush();

            // On créer notre retour json
            $jsonReturn = ['code' => '1', 'message' => 'Utilisateur supprimé'];
        }

        // On retourne le résultat
        return $app->json($jsonReturn);
    }


    /**
     * @param Application $app
     * @return EntityManager
     */
    public function getEntityManager(Application $app): EntityManager
    {
        return $app['orm.em'];
    }

}