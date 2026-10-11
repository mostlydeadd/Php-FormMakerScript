<?php
namespace framework\captcha;

use framework\session\Session;

/**
 * Session-backed arithmetic CAPTCHA. Does not require GD or font files.
 */
class Captcha
{
    const SESSION_NAME = 'captcha';

    /**
     * Create a fresh arithmetic question and store its answer in the session.
     *
     * @return string Human-readable question for the login form.
     */
    public function createQuestion()
    {
        Session::instance()->open();

        $a = random_int(2, 20);
        $b = random_int(1, 20);
        $operator = random_int(0, 1) ? '+' : '-';

        if ($operator === '-' && $b > $a) {
            $tmp = $a;
            $a = $b;
            $b = $tmp;
        }

        $answer = ($operator === '+') ? $a + $b : $a - $b;
        Session::instance()->set(self::SESSION_NAME, (string) $answer);

        return $a . ' ' . $operator . ' ' . $b . ' = ?';
    }

    /**
     * Backwards-compatible endpoint behavior: print a text question instead
     * of attempting to generate a GD image.
     *
     * @return void
     */
    public function create()
    {
        $question = $this->createQuestion();
        header('Content-Type: text/plain; charset=UTF-8');
        echo $question;
    }

    /**
     * Validate the submitted answer and invalidate it after one attempt.
     *
     * @param string $captcha
     * @return bool
     */
    public function validate($captcha)
    {
        Session::instance()->open();
        $expected = Session::instance()->get(self::SESSION_NAME);
        Session::instance()->delete(self::SESSION_NAME);

        if (!is_scalar($expected) || !is_scalar($captcha)) {
            return false;
        }

        return hash_equals((string) $expected, trim((string) $captcha));
    }
}
