<?php

namespace Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Models\Role;
use Models\UsersModel;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController
{
    public function getHomepage(Request $request, Application $app)
    {
        $allUsersArrayObject = $this->getEntityManager($app)
            ->getRepository(UsersModel::class)
            ->findAll();
        $users = [];
        foreach ($allUsersArrayObject as $userObject) {
            $users[] = $userObject->toArray();
        }

        $user = null;
        $token = $app['security.token_storage']->getToken();        // Get current authentication token
        if ($token !== null) {
            $user = $token->getUser();                              // Get user from token
        }

        return $app['twig']->render('admin/admin.html.twig',
            [
                'users' => $users,      // array of users bdd
                'user' => $user         // user auth
            ]
        );
    }


    /* API */

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
        foreach ($allUsersArrayObject as $userObject) {
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
        if (empty($request->request->get('lastname')) ||
            empty($request->request->get('firstname')) ||
            empty($request->request->get('username')) ||
            empty($request->request->get('roles')) ||
            empty($request->request->get('password'))
        ) {
            // if an params is missing -> return an json with code 0 and staut 400
            return $app->json(['code' => 0, 'message' => 'Paramètre manquant'], 400);
        }

        // Get the EntityManager with method for completion
        $entityManager = $this->getEntityManager($app);

        // Create a new UserModel empty
        $userToStore = new UsersModel();

        // Set the lastname and firstname of my object with the value POST (Doctrine escape the tag)
        $userToStore->setLastname($request->request->get('lastname'));
        $userToStore->setFirstname($request->request->get('firstname'));
        $userToStore->setUsername($request->request->get('username'));
        $userToStore->setPassword($request->request->get('password'));

        $role = $request->request->get('roles');
        $roleInstance = $entityManager->getRepository(Role::class)->findOneByLabel($role);
        if (!$roleInstance){
            throw new NotFoundHttpException('Role ' . $role . ' Not found');
        }
        $userToStore->setRoles([$roleInstance]);

        // add user on the waiting
        $entityManager->persist($userToStore);

        // Execute the task in waiting
        $entityManager->flush();

        // Return the json with code 1 and the new user (with id)
        return $app->json(['code' => 1, 'message' => 'Utilisateur ajouté', 'user' => $userToStore->toArray()]);
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