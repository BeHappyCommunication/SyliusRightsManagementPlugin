<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\Controller;

use BeHappy\SyliusRightsManagementPlugin\Entity\GroupInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class GroupController
 *
 * @package BeHappy\SyliusRightsManagementPlugin\Controller
 */
class GroupController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function createAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        
        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var GroupInterface $newResource */
        $newResource = $this->newResourceFactory->create($configuration, $this->factory);
        
        $service = $this->get('be_happy.rights_management.service.group');
        $service->createMissingRights($newResource);
        
        $form = $this->resourceFormFactory->create($configuration, $newResource);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $newResource = $form->getData();
            
            $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::CREATE, $configuration, $newResource);
            
            if ($event->isStopped() && !$configuration->isHtmlRequest()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }
            if ($event->isStopped()) {
                $this->flashHelper->addFlashFromEvent($configuration, $event);
                
                if ($event->hasResponse()) {
                    return $event->getResponse();
                }
                
                return $this->redirectHandler->redirectToIndex($configuration, $newResource);
            }
            
            if ($configuration->hasStateMachine()) {
                $this->stateMachine->apply($configuration, $newResource);
            }
            
            $this->repository->add($newResource);
            $postEvent = $this->eventDispatcher->dispatchPostEvent(ResourceActions::CREATE, $configuration, $newResource);
            
            if (!$configuration->isHtmlRequest()) {
                return $this->viewHandler->handle($configuration, View::create($newResource, Response::HTTP_CREATED));
            }
            
            $this->flashHelper->addSuccessFlash($configuration, ResourceActions::CREATE, $newResource);
            
            if ($postEvent->hasResponse()) {
                return $postEvent->getResponse();
            }
            
            return $this->redirectHandler->redirectToResource($configuration, $newResource);
        }
        
        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
        }
        
        $this->eventDispatcher->dispatchInitializeEvent(ResourceActions::CREATE, $configuration, $newResource);
        
        $view = View::create()
            ->setData([
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resource' => $newResource,
                $this->metadata->getName() => $newResource,
                'form' => $form->createView(),
            ])
            ->setTemplate($configuration->getTemplate(ResourceActions::CREATE . '.html'))
        ;
        
        return $this->viewHandler->handle($configuration, $view);
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function updateAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        
        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);
        /** @var GroupInterface $resource */
        $resource = $this->findOr404($configuration);
        
        $service = $this->get('be_happy.rights_management.service.group');
        $service->createMissingRights($resource);
        
        $form = $this->resourceFormFactory->create($configuration, $resource);
        
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && $form->handleRequest($request)->isValid()) {
            $resource = $form->getData();
            
            /** @var ResourceControllerEvent $event */
            $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::UPDATE, $configuration, $resource);
            
            if ($event->isStopped() && !$configuration->isHtmlRequest()) {
                throw new HttpException($event->getErrorCode(), $event->getMessage());
            }
            if ($event->isStopped()) {
                $this->flashHelper->addFlashFromEvent($configuration, $event);
                
                if ($event->hasResponse()) {
                    return $event->getResponse();
                }
                
                return $this->redirectHandler->redirectToResource($configuration, $resource);
            }
            
            $this->resourceUpdateHandler->handle($resource, $configuration, $this->manager);
            
            
            $postEvent = $this->eventDispatcher->dispatchPostEvent(ResourceActions::UPDATE, $configuration, $resource);
            
            if (!$configuration->isHtmlRequest()) {
                $view = $configuration->getParameters()->get('return_content', false) ? View::create($resource, Response::HTTP_OK) : View::create(null, Response::HTTP_NO_CONTENT);
                
                return $this->viewHandler->handle($configuration, $view);
            }
            
            $this->flashHelper->addSuccessFlash($configuration, ResourceActions::UPDATE, $resource);
            
            if ($postEvent->hasResponse()) {
                return $postEvent->getResponse();
            }
            
            return $this->redirectHandler->redirectToResource($configuration, $resource);
        }
        
        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($form, Response::HTTP_BAD_REQUEST));
        }
        
        $this->eventDispatcher->dispatchInitializeEvent(ResourceActions::UPDATE, $configuration, $resource);
        
        $view = View::create()
            ->setData([
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resource' => $resource,
                $this->metadata->getName() => $resource,
                'form' => $form->createView(),
            ])
            ->setTemplate($configuration->getTemplate(ResourceActions::UPDATE . '.html'))
        ;
        
        return $this->viewHandler->handle($configuration, $view);
    }
}
