<?php declare(strict_types=1);

namespace ShoppableImage;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;

class ShoppableImage extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        // Do stuff such as creating a new payment method
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if ($uninstallContext->keepUserData()) {
            return;
        }

        // Remove or deactivate the data created by the plugin
    }

    public function activate(ActivateContext $activateContext): void
    {
        // Activate entities, such as a new payment method
        // Or create new entities here, because now your plugin is installed and active for sure
    }

    public function deactivate(DeactivateContext $deactivateContext): void
    {
        // Deactivate entities, such as a new payment method
        // Or remove previously created entities
    }

    public function update(UpdateContext $updateContext): void
    {
        // Update necessary stuff, mostly non-database related
    }

    public function postInstall(InstallContext $installContext): void
    {
    }

    public function postUpdate(UpdateContext $updateContext): void
    {
    }

    public function getCmsElementConfig(): array
    {
        return [
            'shoppable-image' => [
                'name' => 'shoppable-image',
                'label' => [
                    'en-GB' => 'Shoppable Image',
                    'de-DE' => 'Shoppable Bild'
                ],
                'defaultConfig' => [
                    'media' => [
                        'source' => 'static',
                        'value' => null,
                        'required' => true,
                        'entity' => ['name' => 'media']
                    ],
                    'hotspots' => [
                        'source' => 'static',
                        'value' => []
                    ],
                    'roomCategory' => [
                        'source' => 'static',
                        'value' => 'all'
                    ]
                ]
            ]
        ];
    }
}
