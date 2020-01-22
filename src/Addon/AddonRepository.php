<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Model\EloquentRepository;

/**
 * Class AddonRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonRepository extends EloquentRepository
{

    /**
     * The repository model.
     *
     * @var AddonModel
     */
    protected $model;

    /**
     * Create a new AddonRepository instance.
     *
     * @param AddonModel $model
     */
    public function __construct(AddonModel $model)
    {
        $this->model = $model;
    }

    /**
     * Mark a module as installed.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function install(Addon $addon)
    {
        if (!$addon = $this->findBy('namespace', $addon->getNamespace())) {
            $addon = $this->newInstance(['namespace' => $addon->getNamespace()]);
        }

        $addon->installed = true;
        $addon->enabled   = true;

        return $addon->save();
    }

    /**
     * Mark a module as uninstalled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function uninstall(Addon $addon)
    {
        if (!$addon = $this->findBy('namespace', $addon->getNamespace())) {
            return true;
        }

        $addon->installed = false;
        $addon->enabled   = false;

        return $addon->save();
    }

    /**
     * Mark a module as disabled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function disable(Addon $addon)
    {
        $addon = $this->findBy('namespace', $addon->getNamespace());

        $addon->enabled = false;

        return $addon->save();
    }

    /**
     * Mark a module as enabled.
     *
     * @param  Addon $addon
     * @return bool
     */
    public function enabled(Addon $addon)
    {
        $addon = $this->findBy('namespace', $addon->getNamespace());

        $addon->enabled = true;

        return $addon->save();
    }
}
