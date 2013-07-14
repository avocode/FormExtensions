<?php

namespace Avocode\FormExtensionsBundle\Form\Type;

use Avocode\FormExtensionsBundle\Form\EventListener\CollectionUploadSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class CollectionUploadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new CollectionUploadSubscriber(
            $builder->getName(), 
            $options
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['multipart']                = json_encode(true);
        $view->vars['primary_key']              = json_encode($options['primary_key']);
        $view->vars['nameable']                 = json_encode($options['nameable']);
        $view->vars['nameable_field']           = json_encode($options['nameable_field']);
        $view->vars['sortable']                 = json_encode($options['sortable']);
        $view->vars['sortable_field']           = json_encode($options['sortable_field']);
        $view->vars['editable']                 = json_encode($options['editable']);
        $view->vars['maxNumberOfFiles']         = json_encode($options['maxNumberOfFiles']);
        $view->vars['maxFileSize']              = json_encode($options['maxFileSize']);
        $view->vars['minFileSize']              = json_encode($options['minFileSize']);
        $view->vars['acceptFileTypes']          = json_encode($options['acceptFileTypes']);
        $view->vars['previewSourceFileTypes']   = json_encode($options['previewSourceFileTypes']);
        $view->vars['previewSourceMaxFileSize'] = json_encode($options['previewSourceMaxFileSize']);
        $view->vars['previewMaxWidth']          = json_encode($options['previewMaxWidth']);
        $view->vars['previewMaxHeight']         = json_encode($options['previewMaxHeight']);
        $view->vars['previewAsCanvas']          = json_encode($options['previewAsCanvas']);
        $view->vars['previewFilter']            = json_encode($options['previewFilter']);
        $view->vars['prependFiles']             = json_encode($options['prependFiles']);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'primary_key'               =>  'id',
            'nameable'                  =>  true,
            'nameable_field'            =>  'name',
            'sortable'                  =>  false,
            'sortable_field'            =>  'position',
            'editable'                  =>  array(),
            'maxNumberOfFiles'          =>  null,
            'maxFileSize'               =>  null,
            'minFileSize'               =>  null,
            'acceptFileTypes'           =>  '/.*$/i',
            'previewSourceFileTypes'    =>  '/^image\/(gif|jpeg|png)$/',
            'previewSourceMaxFileSize'  =>  5000000,
            'previewMaxWidth'           =>  80,
            'previewMaxHeight'          =>  80,
            'previewAsCanvas'           =>  true,
            'previewFilter'             =>  null,
            'prependFiles'              =>  false,
        ));

        $resolver->setAllowedTypes(array(
            'primary_key'               =>  array('string'),
            'nameable'                  =>  array('bool'),
            'nameable_field'            =>  array('string'),
            'sortable'                  =>  array('bool'),
            'sortable_field'            =>  array('string'),
            'editable'                  =>  array('array'),
            'maxNumberOfFiles'          =>  array('integer', 'null'),
            'maxFileSize'               =>  array('integer', 'null'),
            'minFileSize'               =>  array('integer', 'null'),
            'acceptFileTypes'           =>  array('string'),
            'previewSourceFileTypes'    =>  array('string'),
            'previewSourceMaxFileSize'  =>  array('integer'),
            'previewMaxWidth'           =>  array('integer'),
            'previewMaxHeight'          =>  array('integer'),
            'previewAsCanvas'           =>  array('bool'),
            'previewFilter'             =>  array('string', 'null'),
            'prependFiles'              =>  array('bool'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'collection_upload';
    }
}
