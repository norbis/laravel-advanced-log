<?php
namespace Norbis\AdvancedLog\Log\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\NormalizerFormatter;

class TelegramFormatter extends LineFormatter
{
    public const SIMPLE_FORMAT = "%channel%.%level_name%:\n%message%\n%context%\n\n%extra%\n";

    /**
     * @inheritdoc
     */
    public function __construct(?string $format = null, ?string $dateFormat = null, bool $allowInlineLineBreaks = true, bool $ignoreEmptyContextAndExtra = true)
    {
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
        $this->includeStacktraces(false);
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record): string
    {
        $vars = NormalizerFormatter::format($record);
        $contextLines = [];
        foreach ($vars['context'] as $var => $val) {
            $contextLines[] = "<b>$var</b>\n<pre>{$this->stringify($val)}</pre>";
        }
        $vars['context'] = implode("\n", $contextLines);

        $extraLines = [];
        foreach ($vars['extra'] as $var => $val) {
            $extraLines[] = "<b>$var</b>\n" . $this->stringify($val);
        }
        $vars['extra'] = implode("\n", $extraLines);

        $output = $this->format;
        if ($this->ignoreEmptyContextAndExtra) {
            if (empty($vars['context'])) {
                unset($vars['context']);
                $output = str_replace('%context%', '', $output);
            }

            if (empty($vars['extra'])) {
                unset($vars['extra']);
                $output = str_replace('%extra%', '', $output);
            }
        }

        foreach ($vars as $var => $val) {
            if (false !== strpos($output, '%'.$var.'%')) {
                $output = str_replace('%'.$var.'%', $this->stringify($val), $output);
            }
        }

        // remove leftover %extra.xxx% and %context.xxx% if any
        if (false !== strpos($output, '%')) {
            $output = preg_replace('/%(?:extra|context)\..+?%/', '', $output);
        }

        return $output;
    }
}
