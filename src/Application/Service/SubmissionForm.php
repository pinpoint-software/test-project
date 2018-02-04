<?php
namespace Application\Service;

class SubmissionForm
{
    public function __invoke($warning = false)
    {
        return [
            'success' => true,
            'warning' => $warning,
        ];
    }
}
