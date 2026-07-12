<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_mentions')]
    public function mentions(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument(
                'mantions_legales.txt',
                'Mentions légales',
                'Les informations d’identification de l’éditeur du site, de l’hébergeur et les règles générales d’utilisation du site.',
                '5 min'
            ),
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'app_legal_privacy')]
    public function privacy(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument(
                'Politique_de_confidentialité.txt',
                'Politique de confidentialité',
                'La manière dont les données personnelles sont collectées, utilisées, conservées et protégées sur le site.',
                '6 min'
            ),
        ]);
    }

    #[Route('/conditions-generales-de-vente', name: 'app_legal_terms')]
    public function terms(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument(
                'CGV..txt',
                'Conditions Générales de Vente',
                'Les règles contractuelles applicables aux prestations proposées, notamment les responsabilités, garanties et modalités de règlement des litiges.',
                '8 min'
            ),
        ]);
    }

    private function buildDocument(string $fileName, string $fallbackTitle, string $summary, string $readingTime): array
    {
        $path = dirname((string) $this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR . 'Docs' . DIRECTORY_SEPARATOR . $fileName;
        $content = is_file($path) ? (string) file_get_contents($path) : '';
        $content = $this->normalizeEncoding($content);
        $content = str_replace(["\r\n", "\r"], "\n", trim($content));

        if ($fileName === 'CGV..txt') {
            $content = preg_replace('/^.*?(?=^#\s*Article\s+1\b)/ms', '', $content) ?? $content;
            $content = preg_replace('/^#\s*J\'ai encore deux recommandations[\s\S]*$/m', '', $content) ?? $content;
        }

        $updatedAt = $this->formatFrenchDate(is_file($path) ? (int) filemtime($path) : time());
        $lines = array_values(array_filter(array_map('trim', explode("\n", $content)), static fn (string $line): bool => $line !== ''));

        if ($lines !== [] && $fileName !== 'CGV..txt' && !preg_match('/^(Article\s+\d+|\d+\.)/', $lines[0])) {
            array_shift($lines);
        }

        if (isset($lines[0]) && str_starts_with($lines[0], 'Dernière mise à jour')) {
            $updatedAt = trim((string) preg_replace('/^Dernière mise à jour\s*:\s*/', '', $lines[0]));
            array_shift($lines);
        }

        $body = trim(implode("\n", $lines));

        return [
            'title' => $fallbackTitle,
            'summary' => $summary,
            'updatedAt' => $updatedAt,
            'readingTime' => $readingTime,
            'sections' => $this->extractSections($body, $fileName === 'CGV..txt'),
        ];
    }

    /**
     * @return array<int, array{title: string, contentHtml: string}>
     */
    private function extractSections(string $body, bool $isTerms): array
    {
        $pattern = $isTerms
            ? '/^#?\s*(Article\s+\d+\s+.+)$/m'
            : '/^(\d+\.\s+.+)$/m';

        $parts = preg_split($pattern, $body, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) ?: [];

        if ($parts === []) {
            return [[
                'title' => 'Contenu',
                'contentHtml' => $this->formatRichText($body),
            ]];
        }

        $sections = [];
        $partsCount = count($parts);

        for ($index = 0; $index < $partsCount; $index += 2) {
            $sectionTitle = trim((string) ($parts[$index] ?? ''));
            $sectionContent = trim((string) ($parts[$index + 1] ?? ''));

            if ($sectionTitle === '') {
                continue;
            }

            $sectionContent = preg_replace('/^#\s*$/m', '', $sectionContent) ?? $sectionContent;

            $sections[] = [
                'title' => $sectionTitle,
                'contentHtml' => $this->formatRichText($sectionContent),
            ];
        }

        return $sections !== [] ? $sections : [[
            'title' => 'Contenu',
            'contentHtml' => $this->formatRichText($body),
        ]];
    }

    private function formatRichText(string $content): string
    {
        $lines = preg_split('/\n/', trim($content)) ?: [];
        $html = [];
        $paragraph = [];
        $listItems = [];
        $quoteLines = [];

        $flushParagraph = function () use (&$html, &$paragraph): void {
            if ($paragraph === []) {
                return;
            }

            $formattedLines = array_map(fn (string $line): string => $this->formatInlineText($line), $paragraph);
            $html[] = '<p>' . implode('<br>', $formattedLines) . '</p>';
            $paragraph = [];
        };

        $flushList = function () use (&$html, &$listItems): void {
            if ($listItems === []) {
                return;
            }

            $items = array_map(fn (string $item): string => '<li>' . $this->formatInlineText($item) . '</li>', $listItems);
            $html[] = '<ul>' . implode('', $items) . '</ul>';
            $listItems = [];
        };

        $flushQuote = function () use (&$html, &$quoteLines): void {
            if ($quoteLines === []) {
                return;
            }

            $formattedLines = array_map(fn (string $line): string => $this->formatInlineText($line), $quoteLines);
            $html[] = '<blockquote><p>' . implode('<br>', $formattedLines) . '</p></blockquote>';
            $quoteLines = [];
        };

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if ($trimmedLine === '' || $trimmedLine === '---') {
                $flushParagraph();
                $flushList();
                $flushQuote();
                continue;
            }

            if (preg_match('/^#{1,6}\s+(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushList();
                $flushQuote();
                $html[] = '<h3>' . $this->formatInlineText($matches[1]) . '</h3>';
                continue;
            }

            if (preg_match('/^\*\s+(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushQuote();
                $listItems[] = $matches[1];
                continue;
            }

            if (preg_match('/^>\s*(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushList();
                $quoteLines[] = $matches[1];
                continue;
            }

            $flushList();
            $flushQuote();
            $paragraph[] = $trimmedLine;
        }

        $flushParagraph();
        $flushList();
        $flushQuote();

        return implode("\n", $html);
    }

    private function formatInlineText(string $text): string
    {
        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $escaped = preg_replace_callback(
            '/\[(.+?)\]\((https?:\/\/[^\s)]+|mailto:[^)]+)\)/',
            static fn (array $matches): string => sprintf(
                '<a href="%s">%s</a>',
                htmlspecialchars($matches[2], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                $matches[1]
            ),
            $escaped
        ) ?? $escaped;

        $escaped = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped) ?? $escaped;

        return $escaped;
    }

    private function normalizeEncoding(string $content): string
    {
        if ($content === '') {
            return $content;
        }

        if (preg_match('//u', $content) === 1) {
            return $content;
        }

        return mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
    }

    private function formatFrenchDate(int $timestamp): string
    {
        $months = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
        ];

        $day = (int) date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp)] ?? '';
        $year = date('Y', $timestamp);

        return sprintf('%d %s %s', $day, $month, $year);
    }
}
