<?php

namespace AuthBundle\Controller;


use AppBundle\Helper\PaginatedResource;
use AppBundle\Helper\PaginatedResourceFactory;
use AuthBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Get("/{user}", requirements={"user"="\d+"})
     * @ApiDoc(
     *      section="Users",
     * )
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @ParamConverter("user", class="AuthBundle:User")
     *
     * @param User $user
     *
     * @return User
     */
    public function getAction(User $user)
    {
        return $user;
    }

    /**
     * @Get("")
     * @ApiDoc(
     *  section="Users",
     *  resource=true,
     *  description="Get users."
     * )
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @QueryParam(name="page", description="Page, 0-indexed.", default=0, requirements="\d+")
     * @QueryParam(name="per_page", description="Elements per page. Maximum 1000.", default=10, requirements="\d+")
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return PaginatedResource
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        $handler = $this->get('un.user_handler');

        $page = (int) $paramFetcher->get('page');
        $perPage = (int) $paramFetcher->get('per_page');

        $paginator = $handler->getPaginated($page, $perPage);

        return PaginatedResourceFactory::fromPaginator($paginator, $page);
    }

    /**
     * @Post("")
     * @ApiDoc(
     *  section="Users",
     *  description="Create user.",
     *  input="AP\Bundle\UserBundle\Form\UserForm"
     * )
     *
     * @param Request $request
     *
     * @return array
     */
    public function postAction(Request $request)
    {
        $handler = $this->get('un.user_handler');

        /** @var User $user */
        $user = $handler->post($request->request->all());

        $data = [
            'resource_id' => $user->getId(),
            '_link' => $this->route($user),
        ];

        return View::create($data, Response::HTTP_CREATED);
    }

    /**
     * @Patch("/{user}", requirements={"user"="\d+"})
     * @ApiDoc(
     *  section="Users",
     *  description="Modify user.",
     *  input="AuthBundle\Form\UserForm"
     * )
     *
     * @ParamConverter("user", class="AuthBundle:User")
     *
     * @param Request $request
     * @param User $user
     *
     * @return array
     */
    public function patchAction(Request $request, User $user)
    {
        if ($user !== $this->getUser() && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException();
        }
        $handler = $this->get('un.user_handler');

        /** @var User $user */
        $user = $handler->patch($request->request->all(), $user);

        return [
            'resource_id' => $user->getId(),
            '_link' => $this->route($user),
        ];
    }

    /**
     * @Delete("/{user}", requirements={"user"="\d+"})
     * @ApiDoc(
     *  section="Users",
     *  description="Delete user."
     * )
     *
     * @ParamConverter("user", class="AuthBundle:User")
     *
     * @param User $user
     */
    public function deleteAction(User $user)
    {
        if ($user !== $this->getUser() && !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException();
        }
        $this->get('un.user_handler')->delete($user);
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
