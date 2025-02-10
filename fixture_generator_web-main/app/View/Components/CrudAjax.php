<?php

namespace App\View\Components;

use App\Http\Controllers\Backend\BaseController;
use Illuminate\View\Component;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class CrudAjax extends Component
{
    use FormBuilderTrait;

    public ?BaseController $controller = null;
    public $form = null;
    public ?array $urls = null;
    public bool $renderable = true;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $store = false, public $update = false)
    {
        $request = request();
        $route = $request->route();
        $controller = $route->getController();

        if($controller instanceof BaseController){
            $this->controller = $controller;
            $this->urls = $this->prepareUrls($controller);
            $this->prepareForm();
        }
        else{
            $this->renderable = false;
        }

    }

    public function prepareForm(){

        $form = $this->plain([
            'method' => 'POST',
            'url' => route($this->controller->getContainer()->page.'.store'),
            'class' => 'ajax-form row g-4',
            'attributes' => [
                'data-action' => 'true'
            ]
        ]);

        if($this->controller->ajaxFields == null or count($this->controller->ajaxFields) == 0){
            $this->renderable = false;
            return;
        }

        foreach($this->controller->ajaxFields as $field => $opt){
            $extraAttr = [];
            if($opt['type'] == 'select'){
                $extraAttr = [
                    'data-control' => 'select2',
                    'data-placeholder' => __('models.'.$this->controller->getContainer()->page.'.'.$field),
                    'data-dropdown-parent' => '#ajax-modal'
                ];
            }

            $attr = [
                'label' => __('models.'.$this->controller->getContainer()->page.'.'.$field),
                'label_attr' => [
                    'class' => 'form-label',
                    ...$opt['label_attr'] ?? []
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' =>  __('models.'.$this->controller->getContainer()->page.'.'.$field),
                    ...$extraAttr,
                    ...$opt['attr'] ?? []
                ],
            ];

            unset($opt['label_attr']);
            unset($opt['attr']);

            if($opt['type'] == 'checkbox'){
                $attr['wrapper'] = [
                    'class' => 'form-check form-switch form-check-custom form-check-solid mt-auto'
                ];

                $attr['label_attr'] = [
                    'class' => 'form-check-label'
                ];

                $attr['attr'] = [
                    ...$attr['attr'],
                    'class' => 'form-check-input form-control',
                    'type' => 'checkbox',
                    'checked' => 'checked'
                ];
            }

            if(is_array($opt)){
                if(!array_key_exists('type', $opt)){
                    throw new \Exception('Type must be defined in array');
                }

                $type = $opt['type'];
                unset($opt['type']);

                foreach($opt as $key => $value){
                    $attr[$key] = $value;
                }
            }
            else{
                $type = $opt;
            }

            if(!array_key_exists('wrapper', $attr)){
                $attr['wrapper'] = [
                    'class' => 'form-group'
                ];
            }

            if(!str_contains($attr['wrapper']['class'], 'col-')){
                $attr['wrapper']['class'] .= count($this->controller->ajaxFields) > 1 ? ' col-md-6' : ' col-md-12';
            }

            try {
                $form->add($field, $type, $attr);
            } catch (\Throwable $th) {
                dd($attr);
            }
        }

        $form->add('submit', Field::BUTTON_SUBMIT, [
            'label' => __('components.form.save'),
            'wrapper' => [
                'class' => 'd-flex justify-content-center'
            ],
            'attr' => [
                'class' => 'btn btn-primary w-100'
            ]
        ]);

        $form->add('reset', Field::BUTTON_RESET,[
            'label' => __('components.form.cancel'),
            'wrapper' => [
                'class' => 'd-flex justify-content-center'
            ],
            'attr' => [
                'class' => 'btn btn-secondary w-100'
            ]
        ]);

        $this->form = $form;
    }

    public function prepareUrls($controller){
        return [
            'store' => route($controller->getContainer()->page.'.store'),
            'update' => route($controller->getContainer()->page.'.update'),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if($this->controller != null and $this->renderable)
            return view('components.crud-ajax');
    }
}
