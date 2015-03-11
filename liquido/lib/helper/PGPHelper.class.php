<?php

class PGPHelper {

  /**
   * @var pgp GnuPG object
   */
  var $pgp = null;
  /**
   * @var array Array of added encrypt keys
   */
  var $fingerprints = array();

  /**
   * Constructor
   * @param string $path Absolute path to the directory where the gnupg files are stored
   */
  public function __construct($path) {
    if (is_dir($path)) {
      putenv('GNUPGHOME=' . $path);
    } else {
      throw new InvalidArgumentException('Home directory does not exist.');
    }
    $this->pgp = new gnupg();
  }

  /**
   * Encrypts the given text with the key of the given fingerprint
   * @param string $fingerprint Key fingerprint
   * @param string $text Text
   * @return string PGP Message
   */
  public function encrypt($fingerprint, $text) {
    if (!isset($this->fingerprints[$fingerprint])) {
      if ($this->pgp->addencryptkey($fingerprint)) {
        $this->fingerprints[$fingerprint] = true;
      } else {
        throw new InvalidArgumentException('Could not add crypt key.');
      }
    }
    return $this->pgp->encrypt($text);
  }
}
