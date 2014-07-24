<?php

namespace Avocode\FormExtensionsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Processes twig configuration
 *
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class FormCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (($twigConfiguration = $container->getParameter('avocode.form.twig')) !== false) {
            $resources = $container->getParameter('twig.form.resources');
            $alreadyImported = in_array('AvocodeFormExtensionsBundle:Form:form_html.html.twig', $resources)
                            && in_array('AvocodeFormExtensionsBundle:Form:form_js.html.twig', $resources)
                            && in_array('AvocodeFormExtensionsBundle:Form:form_css.html.twig', $resources);

            if ($twigConfiguration['use_form_resources'] && !$alreadyImported) {
                // Insert right after form_div_layout.html.twig if exists
                if (($key = array_search('form_div_layout.html.twig', $resources)) !== false) {
                    array_splice($resources, ++$key, 0, array(
                        'AvocodeFormExtensionsBundle:Form:form_html.html.twig',
                        'AvocodeFormExtensionsBundle:Form:form_js.html.twig',
                        'AvocodeFormExtensionsBundle:Form:form_css.html.twig'
                    ));
                } else {
                    // Put it in first position
                    array_unshift($resources, array(
                        'AvocodeFormExtensionsBundle:Form:form_html.html.twig',
                        'AvocodeFormExtensionsBundle:Form:form_js.html.twig',
                        'AvocodeFormExtensionsBundle:Form:form_css.html.twig'
                    ));
                }

                $container->setParameter('twig.form.resources', $resources);
            }
        }
    }
}
