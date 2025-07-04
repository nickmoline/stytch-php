<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\Users;
use Stytch\Shared\Client;

class UsersTest extends TestCase
{
    public function testCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/users', ['email' => 'user@example.com'])
            ->willReturn(['created' => true]);

        $users = new Users($mock);
        $result = $users->create(['email' => 'user@example.com']);
        $this->assertEquals(['created' => true], $result);
    }

    public function testGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/users/user123')
            ->willReturn(['user' => []]);

        $users = new Users($mock);
        $result = $users->get('user123');
        $this->assertEquals(['user' => []], $result);
    }

    public function testSearchCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/users/search', ['limit' => 10])
            ->willReturn(['results' => []]);

        $users = new Users($mock);
        $result = $users->search(['limit' => 10]);
        $this->assertEquals(['results' => []], $result);
    }

    public function testUpdateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('put')
            ->with('/v1/users/user123', ['name' => 'John'])
            ->willReturn(['updated' => true]);

        $users = new Users($mock);
        $result = $users->update('user123', ['name' => 'John']);
        $this->assertEquals(['updated' => true], $result);
    }

    public function testExchangePrimaryFactorCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('put')
            ->with('/v1/users/user123/exchange_primary_factor', ['email_address' => 'new@example.com'])
            ->willReturn(['exchanged' => true]);

        $users = new Users($mock);
        $result = $users->exchangePrimaryFactor('user123', ['email_address' => 'new@example.com']);
        $this->assertEquals(['exchanged' => true], $result);
    }

    public function testDeleteCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/user123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->delete('user123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteEmailCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/emails/email123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteEmail('email123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeletePhoneNumberCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/phone_numbers/phone123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deletePhoneNumber('phone123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteWebAuthnRegistrationCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/webauthn_registrations/webauthn123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteWebAuthnRegistration('webauthn123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteBiometricRegistrationCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/biometric_registrations/bio123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteBiometricRegistration('bio123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteTOTPCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/totps/totp123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteTOTP('totp123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteCryptoWalletCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/crypto_wallets/wallet123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteCryptoWallet('wallet123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeletePasswordCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/passwords/password123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deletePassword('password123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testDeleteOAuthRegistrationCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/users/oauth_registrations/oauth123')
            ->willReturn(['deleted' => true]);

        $users = new Users($mock);
        $result = $users->deleteOAuthRegistration('oauth123');
        $this->assertEquals(['deleted' => true], $result);
    }

    public function testConnectedAppsCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/users/user123/connected_apps')
            ->willReturn(['apps' => []]);

        $users = new Users($mock);
        $result = $users->connectedApps('user123');
        $this->assertEquals(['apps' => []], $result);
    }

    public function testRevokeCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/users/user123/connected_apps/app123/revoke')
            ->willReturn(['revoked' => true]);

        $users = new Users($mock);
        $result = $users->revoke('user123', 'app123');
        $this->assertEquals(['revoked' => true], $result);
    }
}
