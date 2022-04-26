<?php

declare(strict_types=1);

namespace Aeliot\Bundle\TransMaintain\Service\Yaml;

final class KeysParser
{
    private FileToSingleLevelArrayParser $fileParser;

    public function __construct(FileToSingleLevelArrayParser $fileParser)
    {
        $this->fileParser = $fileParser;
    }

    public function getOmittedKeys(array $parsedKeys): array
    {
        $allDomainKeys = $this->mergeKeys($parsedKeys);
        $locales = array_keys($parsedKeys);
        sort($locales);
        $omittedKeys = array_fill_keys($locales, null);
        foreach ($parsedKeys as $locale => $localeKeys) {
            $omittedKeys[$locale] = array_diff($allDomainKeys, $localeKeys);
        }

        return $omittedKeys;
    }

    public function getParsedKeys(array $localesFiles): array
    {
        $keys = [];
        foreach ($localesFiles as $locale => $files) {
            $keys[$locale] = $this->getKeys($this->parseFiles($files));
        }

        return $keys;
    }

    public function mergeKeys(array $keys): array
    {
        $merged = array_unique(array_merge(...array_values($keys)));
        sort($merged);

        return $merged;
    }

    public function parseFiles(array $files): array
    {
        $values = [];
        foreach ($files as $file) {
            foreach ($this->fileParser->parse($file) as $key => $value) {
                $values[$key] = $value;
            }
        }

        return $values;
    }

    private function getKeys(array $values): array
    {
        $keys = array_keys($values);
        sort($keys);

        return $keys;
    }
}
