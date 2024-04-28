<?php

namespace toby7002\Phenol;

class LanguageProvider
{
    /**
     * @var string[] $translations
     */
    private array $translations = [];

    public function loadTranslationsFromJSON(string $name, string $path): void
    {
        $this->translations = json_decode(file_get_contents($path) ?: "", true);
    }

    public function getText(string $key, array $placeholders = []): string
    {
        if (!array_key_exists($key, $this->translations)) {
            return $key;
        }

        $translation = $this->translations[$key];

        foreach ($placeholders as $placeholderKey => $placeholderValue) {
            $translation = str_replace("{{" . $placeholderKey . "}}", (string) $placeholderValue, $translation);
        }

        return $translation;
    }
}
