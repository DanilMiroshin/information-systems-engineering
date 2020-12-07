<?php
/* Form */
interface Form
{
    public function getForm(): string;
}

class WindowsForm implements Form
{
    public function getForm(): string
    {
        return ' Windows form ';
    }
}

class LinuxForm implements Form
{
    public function getForm(): string
    {
        return ' Linux form ';
    }
}


/* Button */
interface Button
{
    public function getButton(): string;
}

class WindowsButton implements Button
{
    public function getButton(): string
    {
        return ' Windows button ';
    }
}

class LinuxButton implements Button
{
    public function getButton(): string
    {
        return ' Linux button ';
    }
}

/* Label */
interface Label
{
    public function getLabel(): string;
}

class WindowsLabel implements Label
{
    public function getLabel() : string
    {
        return ' Windows label ';
    }
}

class LinuxLabel implements Label
{
    public function getLabel() : string
    {
        return ' Linux label ';
    }
}


interface FormBuilder
{
    public function createButton();

    public function createLabel();
}

class WindowsFormBuilder implements FormBuilder
{
    private $form;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->form = new WindowsForm();
        $this->form->parts[] = $this->form->getForm();
    }

    public function createButton(): void
    {
        $button = new WindowsButton();
        $this->form->parts[] = $button->getButton();
    }

    public function createLabel(): void
    {
        $label = new WindowsLabel();
        $this->form->parts[] = $label->getLabel();
    }

    public function showForm(): void
    {
        echo implode(', ', $this->form->parts) . "\n\n";
    }
}

class LinuxFormBuilder implements FormBuilder
{
    private $form;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->form = new LinuxForm();
        $this->form->parts[] = $this->form->getForm();
    }

    public function createButton(): void
    {
        $button = new LinuxButton();
        $this->form->parts[] = $button->getButton();
    }

    public function createLabel(): void
    {
        $label = new LinuxLabel();
        $this->form->parts[] = $label->getLabel();
    }

    public function showForm(): void
    {
        echo implode(', ', $this->form->parts) . "\n\n";
    }
}

$form = new LinuxFormBuilder();
$form->createButton();
$form->showForm();
