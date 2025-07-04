<?php

namespace Stytch\B2B;

use Stytch\Shared\Client as BaseClient;

class Client extends BaseClient
{
    public Discovery $discovery;
    public Impersonation $impersonation;
    public MagicLinks $magicLinks;
    public OAuth $oauth;
    public OTPs $otps;
    public Organizations $organizations;
    public Passwords $passwords;
    public RBAC $rbac;
    public RecoveryCodes $recoveryCodes;
    public SCIM $scim;
    public Sessions $sessions;
    public SSO $sso;
    public TOTPs $totps;
    public IDP $idp;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        // Initialize all B2B services
        $this->discovery = new Discovery($this);
        $this->impersonation = new Impersonation($this);
        $this->magicLinks = new MagicLinks($this);
        $this->oauth = new OAuth($this);
        $this->otps = new OTPs($this);
        $this->organizations = new Organizations($this);
        $this->passwords = new Passwords($this);
        $this->rbac = new RBAC($this);
        $this->recoveryCodes = new RecoveryCodes($this);
        $this->scim = new SCIM($this);
        $this->sessions = new Sessions($this);
        $this->sso = new SSO($this);
        $this->totps = new TOTPs($this);
        $this->idp = new IDP($this);
    }
}
