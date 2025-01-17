<?php

declare(strict_types=1);

/*
 * This file is part of the TransMaintain.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\Bundle\TransMaintain\Service\Translator;

use Symfony\Component\Translation\TranslatorInterface as LegacyTranslatorInterface;

/**
 * @deprecated since v2.8.0. Use {@see TranslatorV3P4 }
 */
class LegacyTranslator extends AbstractTranslator implements LegacyTranslatorInterface
{
    use TranslatorV3P4Trait;

    /**
     * @param string $id
     * @param int $number
     * @param array<string|int,string|int> $parameters
     * @param string|null $domain
     * @param string|null $locale
     *
     * @return string
     */
    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->translator->transChoice(...\func_get_args());
    }
}
