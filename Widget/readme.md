# WIDGET
This util is made for generating widgets as services that can be used in controllers or other services.

## How to use it ?

### Files architecture
1. In your bundle, create a Widget directory.
 - Inside this directory you will have to create one class that extends the parent MesClics\UtilsBundle\Widget\Widget class for each Widget you want to set. Il will define the structure of the widget.
 - (optional : only for interactive widgets) In a subdirectory called Handler, you will  have to create a class that extends the parent MesClics\UtilsBundle\Widget\Handler\WidgetHandler class for each widget you set. It will define all the operations that will be done on the widget content.

2. (optional). If you want to set a WidgetContainer objects that will contain all the widgets used for a particular task or page, you can create a new file inside the Widget directoy of your bundle that extends the parent MesClics\UtilsBundle\Widget\WidgetsContainer class.

```
+-- MyBundle
|    +-- Widget
|    |    +-- FirstWidget (extends MesClics\UtlisBundle\Widget\Widget)
|    |    +-- MyWidgetsContainer (optional, extends MesClics\UtilsBundle\Widget\WidgetsContainer)
|    |    +-- Handler
|    |    |    +-- FirstWidgetHandler (extends MesClics\UtilsBundle\Widget\Handler\WidgetHandler)
```

### YourWidget class
Create a new Widget class that extends the parent MesClics\UtilsBundle\Widget\Widget one.
Inside this class you must define a constructor that have to set the handler if needed and eventually the parameters that will be usefull to the widget and the handler and 3 additional methods that will define a name, an eventual template's file path for the widget, and an array of eventual variables for the template:

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

### Your WidgetHandler class (optional)
In the Handler sub-directory, create a new class that extends the MesClics\UtilsBundle\Widget\Handler\WidgetHandler parent class.
The hanlder class must define a handleRequest method that will contain the widget's logic.

```php
class FirstWidgetHandler extends MesClic\UtilsBundle\Widget\Handler\WidgetHandler{
    public function handleRequest(Widget $widget, Request $request){
        //be more specific about the widget type hint
        if(!$widget instanceof FirstWidget){
            throw new InvalidArgumentException(__METHOD__." expects first argument to be an instance of FirstWidget, " . get_class($widget) . ' given.');
        }
        
        $widget->getForm()->handleRequest($request);

        if($widget->getForm()->isSubmitted() && $widget->getForm()->isValid()){
            // logic...
        }
    }
}
```

### Your WidgetsContainer class (optional)
A widget container class should be created to centralize the whole widgets logic for an app feature, so it can be directely used by controllers or services. It must extends the MesClics\UtilsBundle\Widget\WidgetsContainer parent class.
Add some attributes and their setters usefull for the container's widgets
Implement an initialize() method that will instanciate all the needed Widgets usefull for the app's feature logic if not already done or on the widgets attributes update.
You also can add some widgets accessors if you want to.

```php
class MyWidgetsContainer extends WidgetsContainer{
    //first pass the handlers to the constructor
    private $first_widget_handler;
    private $param1;
    private $param2;
    
    public function __construct(FirstWidgetHandler $fwh){
        parent::__construct();
        $this->first_widget_handler = $fwh;
    }
    
    public function initialize($params = array()){
        // only at first set or params change
        if($params['param1'] !== $this->param1 || $params['param2'] !== $this->param2){
            $this->setParam1($param1);
            $this->setParam2($param2);
            $this->addWidget(new FirstWidget($this->param1, $this->param2, $this->first_widget_handler));
            $this->addWidget(new SecondWidget($this->param2));
        }
    }

    public getFirstWidget(){
        return $this->getWidget('my_first_widget');
    }

    public function setParam1($param1){
        $this->param1 = $param1;
    }

    public function setParam2($param2){
        $this->param2 = $param2;
    }
}
```
### Use it
Now you can use your Widgets in your controllers or services.

#### Using the widgets container :

```php
public function useWidgetAction($param1, $param2, MyWidgetsContainer $my_widgets_container, Request $request){
    ...
    //first initialize widgets
    //name your widgets attribute as expected by the initialize method'params attribute
    $widgets_params =  array(
        'param1' => $param1,
        'param2' => $param2
    );
    $my_widgets_container->initialize($widgets_params);

    //if needed call the handleRequest of each widget
    if($request->isMethod('POST')){
        $my_wigets_container->handleRequest($request);
    }

    //pass widgets to your view
    $args = array(
        'widgets' => $my_widgets_container->getWidgets()
    );

    return $this->render('MyBundle:Templates:my-view.html.twig', $args);

}
```

#### Directely using a new widget object :
```php
public function useWidgetAction($param1, $param2, FirstWidgetHandler $first_widget_handler, Request $request){
    ...
    $my_first_widget = new FirstWidget($param1, $param2, $first_widget_handler);
    
    //if needed handleRequest
    if($request->isMethod('POST')){
        $my_first_widget->handleRequest($request);
    }

    //pass widget to the view
    $vars = array(
        'my_first_widget' => $my_first_widget
    );

    return $this->render('MyBundle:Templates:my-view.html.twig', $args);

}
```
