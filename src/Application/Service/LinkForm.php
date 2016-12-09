<?php
namespace Application\Service;

class LinkForm
{
    public function __invoke($warning = false)
    {
        return [
            'success' => true,
            'warning' => $warning,
        ];
    }
}
