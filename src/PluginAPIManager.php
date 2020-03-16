<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;
use SternerStuffWordPress\Interfaces\ActionHookSubscriber;
 
/**
 * PluginAPIManager handles registering actions and hooks with the
 * WordPress Plugin API.
 */
class PluginAPIManager
{
    /**
     * Registers an object with the WordPress Plugin API.
     *
     * @param mixed $object
     */
    public function register($object)
    {
        if ($object instanceof ActionHookSubscriber) {
            $this->register_actions($object);
        }
        if ($object instanceof FilterHookSubscriber) {
            $this->register_filters($object);
        }
    }
 
    /**
     * Register an object with a specific action hook.
     *
     * @param ActionHookSubscriber $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function register_action(ActionHookSubscriber $object, $name, $parameters)
    {
        if (is_string($parameters)) {
            add_action($name, array($object, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            add_action($name, array($object, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10, isset($parameters[2]) ? $parameters[2] : 1);
        }
    }
 
    /**
     * Regiters an object with all its action hooks.
     *
     * @param ActionHookSubscriber $object
     */
    private function register_actions(ActionHookSubscriber $object)
    {
        foreach ($object->get_actions() as $name => $parameters) {
            $this->register_action($object, $name, $parameters);
        }
    }
 
    /**
     * Register an object with a specific filter hook.
     *
     * @param FilterHookSubscriber $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function register_filter(FilterHookSubscriber $object, $name, $parameters)
    {
        if (is_string($parameters)) {
            add_filter($name, array($object, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            add_filter($name, array($object, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10, isset($parameters[2]) ? $parameters[2] : 1);
        }
    }
 
    /**
     * Regiters an object with all its filter hooks.
     *
     * @param FilterHookSubscriber $object
     */
    private function register_filters(FilterHookSubscriber $object)
    {
        foreach ($object->get_filters() as $name => $parameters) {
            $this->register_filter($object, $name, $parameters);
        }
    }
}