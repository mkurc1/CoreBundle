<?php

namespace CoreBundle\Form\Handler;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractFormHandler
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @required
     */
    public function setRequest(RequestStack $requestStack): void
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @required
     */
    public function setFormFactory(FormFactoryInterface $formFactory): void
    {
        $this->formFactory = $formFactory;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function isPostMethod(): bool
    {
        return $this->request->isMethod(Request::METHOD_POST);
    }

    public function buildForm(string $type, object $data): void
    {
        $this->form = $this->formFactory->create($type, $data);
    }

    public function createView(): FormView
    {
        return $this->form->createView();
    }

    public function process(): bool
    {
        if (!$this->request->isMethod(Request::METHOD_GET)) {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {
                return $this->doProcessForm();
            }
        }

        return false;
    }

    abstract protected function doProcessForm(): bool;
}
