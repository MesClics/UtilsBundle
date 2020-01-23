# WIDGET
This util is made for generating widgets as services that can be used in controllers or other services.

## How to use it ?

### architecture
Each new extending Widget object will need to have, a corresponding extending WidgetHandler class.

1. In your bundle, create a Widget directory.
 - Inside this directory you will have to create one class that extends the parent MesClics\UtilsBundle\Widget\Widget class for each Widget you want to set.
 - In a subdirectory called Handler, you will  have to create a class that extends the parent MesClics\UtilsBundle\Widget\Handler\WidgetHandler class for each widget you set.

2. For each widget, you have to add two deinition line in the services config file of your bundle. One that defines the MesClics\UtilsBundle\Widget\Widget class as the parent of your new widget class, one that defines the MesClics\UtilsBundle\Widget\Handler\WidgetHandler as the parent of your corresponding widget-handler class.
    ```yaml
    MesClics\MonBundle\Widget\FirstWidget:
        parent: MesClics\UtilsBundle\Widget\Widget
    ```
3. (optional). If you want to set a WidgetContainer objects that will contain all the widgets used for a particular task or page, you can create a new file inside the Widget directoy of your bundle that extends the parent MesClics\UtilsBundle\Widget\WidgetsContainer class.

```
Bundle
    +-- Widget
    |    +-- FirstWidget (extends MesClics\UtlisBundle\Widget\Widget)
    |    +-- MyWidgetsContainer (optional, extends MesClics\UtilsBundle\Widget\WidgetsContainer)
    |    +-- Handler
         |    +-- FirstWidgetHandler (extends MesClics\UtilsBundle\Widget\Handler\WidgetHandler)
    +-- Resources
    |    +-- config
    |    |   +-- services.yaml (add widgets and widgets handlers configs)
```

### YourWidget class
Create a new Widget class that extends the parent MesClics\UtilsBundle\Widget\Widget one.
Inside this class you must define a constructor that have to set the handler and eventually the parameters that will be usefull to the widget and the handler and 3 additional methods that will define a name, an eventual template's file path for the widget, and an array of eventual variables for the template:

```php

class FirstWidget extends MesClics\UtilsBundle\Widget\Widget{
    protected $param1;
    protected $param2;
    protected $form;

    // set contructor. If a form has to be generate for the widget, do it here adding an attribute form to the class and a setter for this attribute. 
    // To be able to use the $this->createForm() method inside the constructor, you first need to set the handler of the widget
    // as it uses the WidgetHandler's createForm method to do so.
    public function __construct($param1, $param2, MyBundle\Widget\Handler\FirstWidgetHandler $handler){
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->handler = $handler;
        $dto = new DTO();
        $dto->mapFrom($param1);
        $this->form = $this->createForm(MyFormType::class, $dto);
    }
    
    public function getName() ? string{
        return 'my_first_widget';
    }

    public function getTemplate() ? string|null{
        return 'MyBundle:Widgets:my_first_widget.html.twig';
    }

    public function getVariables() ? array{
        return array(
            'param1' => $this->getParam1(),
            'param2' => $this->getParam2(),
            'form' => $this->getForm()->createView()
        );
    }

    // add the getters for the widget attributes
    public function getParam1(){
        return $param1;
    }

    public function getParam2(){
        return $param2;
    }

    public function getForm(){
        return $this->form;
    }
}
```

