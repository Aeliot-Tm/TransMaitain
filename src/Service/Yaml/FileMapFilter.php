<?php

declare(strict_types=1);

namespace Aeliot\Bundle\TransMaintain\Service\Yaml;

use Aeliot\Bundle\TransMaintain\Dto\LintYamlFilterDto;

final class FileMapFilter
{
    private FilesFinder $filesFinder;

    public function __construct(FilesFinder $filesFinder)
    {
        $this->filesFinder = $filesFinder;
    }

    /**
     * @return array<string,array<string,array<int,string>>>
     */
    public function getFilesMap(LintYamlFilterDto $filterDto): array
    {
        $filteredFilesMap = [];
        foreach ($this->filesFinder->getFilesMap() as $domain => $localesFiles) {
            if ($filterDto->domains && !\in_array($domain, $filterDto->domains, true)) {
                continue;
            }

            if ($filterDto->locales) {
                $localesFiles = array_intersect_key($localesFiles, array_flip($filterDto->locales));
            }

            if(!$localesFiles){
                continue;
            }

            $filteredFilesMap[$domain] = $localesFiles;
        }

        return $filteredFilesMap;
    }
}
