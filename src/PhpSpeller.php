<?php

/**
 * Created by PhpStorm.
 * User: ibodnar
 * Date: 11.09.15
 * Time: 21:46.
 */
namespace AmaxLab\PhpSpeller;

/**
 * @author Igor Bodnar <ibodnar@amaxlab.ru>
 */
class PhpSpeller
{
    const VERSION = '0.1-DEV';

    /**
     * @return array
     */
    public function getBackends()
    {
        $enchantResource = enchant_broker_init();
        $providers = enchant_broker_describe($enchantResource);
        enchant_broker_free($enchantResource);

        return $providers;
    }

    /**
     * @param array|Word[]   $words
     * @param array|string[] $locales
     *
     * @return SpellResult
     */
    public function check($words, array $locales)
    {
        $misspelledWords = array();

        $enchantResource = enchant_broker_init();
        /*$bprovides = enchant_broker_describe($r);
        echo "Current broker provides the following backend(s):\n";
        print_r($bprovides);*/
        /*$dicts = enchant_broker_list_dicts($r);
        print_r($dicts);*/

        $dictionaries = array();
        foreach ($locales as $locale) {
            if (!enchant_broker_dict_exists($enchantResource, $locale)) {
                // TODO handle and log error
                continue;
            }

            $dictionaries[$locale] = enchant_broker_request_dict($enchantResource, $locale);
        }

            //$dprovides = enchant_dict_describe($dictionary);
            //echo "dictionary $tag provides:\n";

        foreach ($words as $word) {
            $checked = false;
            $suggests = array();
            foreach ($dictionaries as $locale => $dictionary) {
                $suggests[$locale] = array();
                $checked = $checked || enchant_dict_quick_check($dictionary, $word->getWord(), $suggests[$locale]);
            }
            $word->setChecked($checked);
            if (!$word->isChecked()) {
                $word->setSuggests($suggests);
                $misspelledWords[] = $word;
            }
        }

        foreach ($dictionaries as $dictionary) {
            enchant_broker_free_dict($dictionary);
        }

        enchant_broker_free($enchantResource);

        $spellResult = new SpellResult();
        $spellResult->setCountOfWords(count($words));
        $spellResult->setMisspelledWords($misspelledWords);

        return $spellResult;
    }
}
