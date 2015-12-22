<?php

namespace AP\Bundle\UserBundle\Controller;

use AppBundle\Exception\InvalidFormException;
use AuthBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class UserRolesController extends FOSRestController
{
    /**
     * @Patch("/{user}/roles", requirements={"user"="\d+"})
     * @ApiDoc(
     *  section="Users",
     *  description="Update user roles.",
     *  input="user_roles_form"
     * )
     *
     * @ParamConverter("user", class="AuthBundle:User")
     *
     * @param User $user
     * @param Request $request
     *
     * @return array
     *
     * @throws InvalidFormException
     */
    public function patchUserRolesAction(User $user, Request $request)
    {
        $form = $this->get('form.factory')->create('user_roles_form');
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            throw new InvalidFormException($form);
        }

        $data = $form->getData();
        $user->setRoles($data['roles']);

        $this->get('doctrine.orm.default_entity_manager')->flush();

        return [
            'resource_id' => $user->getId(),
            '_link' => $this->route($user),
        ];
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function route(User $user)
    {
        return $this->get('router')->generate('api_1_get_user', ['user' => $user->getId()]);
    }
}
