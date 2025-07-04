<?php

namespace Stytch\B2C;

use Stytch\Shared\Client as BaseClient;
use Stytch\B2C\Attribute;
use Stytch\B2C\CryptoWallets;
use Stytch\B2C\Fraud;
use Stytch\B2C\IDP;
use Stytch\B2C\Impersonation;
use Stytch\B2C\M2M;
use Stytch\B2C\MagicLinks;
use Stytch\B2C\MagicLinksEmail;
use Stytch\B2C\OAuth;
use Stytch\B2C\OTPs;
use Stytch\B2C\OTPsEmail;
use Stytch\B2C\OTPsSms;
use Stytch\B2C\OTPsWhatsapp;
use Stytch\B2C\Passwords;
use Stytch\B2C\PasswordsEmail;
use Stytch\B2C\PasswordsExistingPassword;
use Stytch\B2C\PasswordsSession;
use Stytch\B2C\Project;
use Stytch\B2C\Sessions;
use Stytch\B2C\TOTPs;
use Stytch\B2C\Users;
use Stytch\B2C\WebAuthn;

class Client extends BaseClient
{
    public Attribute $attribute;
    public CryptoWallets $cryptoWallets;
    public Fraud $fraud;
    public IDP $idp;
    public Impersonation $impersonation;
    public M2M $m2m;
    public MagicLinks $magicLinks;
    public MagicLinksEmail $magicLinksEmail;
    public OAuth $oauth;
    public OTPs $otps;
    public OTPsEmail $otpsEmail;
    public OTPsSms $otpsSms;
    public OTPsWhatsapp $otpsWhatsapp;
    public Passwords $passwords;
    public PasswordsEmail $passwordsEmail;
    public PasswordsExistingPassword $passwordsExistingPassword;
    public PasswordsSession $passwordsSession;
    public Project $project;
    public Sessions $sessions;
    public TOTPs $totps;
    public Users $users;
    public WebAuthn $webauthn;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->attribute = new Attribute($this);
        $this->cryptoWallets = new CryptoWallets($this);
        $this->fraud = new Fraud($this);
        $this->idp = new IDP($this);
        $this->impersonation = new Impersonation($this);
        $this->m2m = new M2M($this);
        $this->magicLinks = new MagicLinks($this);
        $this->magicLinksEmail = new MagicLinksEmail($this);
        $this->oauth = new OAuth($this);
        $this->otps = new OTPs($this);
        $this->otpsEmail = new OTPsEmail($this);
        $this->otpsSms = new OTPsSms($this);
        $this->otpsWhatsapp = new OTPsWhatsapp($this);
        $this->passwords = new Passwords($this);
        $this->passwordsEmail = new PasswordsEmail($this);
        $this->passwordsExistingPassword = new PasswordsExistingPassword($this);
        $this->passwordsSession = new PasswordsSession($this);
        $this->project = new Project($this);
        $this->sessions = new Sessions($this);
        $this->totps = new TOTPs($this);
        $this->users = new Users($this);
        $this->webauthn = new WebAuthn($this);
    }
}
