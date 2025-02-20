# Wallet Package for Laravel

This package provides a simple wallet management system for Laravel applications. It allows users to create wallets, manage funds, and transfer money between wallets.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Creating a Wallet](#creating-a-wallet)
  - [Adding Funds](#adding-funds)
  - [Deducting Funds](#deducting-funds)
  - [Transferring Funds](#transferring-funds)
- [Database Migrations](#database-migrations)
- [Publishing Assets](#publishing-assets)
- [Testing](#testing)
- [License](#license)

## Installation

To install the package, run the following command:

```bash
composer require algeriany/wallet
```

## Configuration

After installing, you may want to publish the configuration files using the following commands:

```bash
php artisan vendor:publish --provider="algeriany\wallet\WalletServiceProvider" --tag=models
php artisan vendor:publish --provider="algeriany\wallet\WalletServiceProvider" --tag=migrations
```

## Usage

### Creating a Wallet

To create a wallet for a user or model that uses the `Walletable` trait, you can do the following:

```php
use algeriany\wallet\Models\Wallet;
use algeriany\wallet\Services\WalletService;

// Assuming $user is an instance of a model that uses the Walletable trait
$walletService = new WalletService();
$wallet = $walletService->createWallet($user, 100.00); // Initialize with $100
```

### Adding Funds

You can add funds to an existing wallet:

```php
$walletService->addFunds($wallet, 50.00); // Add $50
```

### Deducting Funds

To deduct funds from a wallet:

```php
try {
    $walletService->deductFunds($wallet, 20.00); // Deduct $20
} catch (\Exception $e) {
    echo $e->getMessage(); // Handle insufficient funds exception
}
```

### Transferring Funds

To transfer funds from one wallet to another:

```php
$fromWallet = Wallet::find($fromWalletId);
$toWallet = Wallet::find($toWalletId);

try {
    $walletService->transferFunds($fromWallet, $toWallet, 30.00); // Transfer $30
} catch (\Exception $e) {
    echo $e->getMessage(); // Handle exceptions
}
```

## Database Migrations

This package includes migrations for creating the `wallets` and `wallet_transfers` tables. To run the migrations, execute:

```bash
php artisan migrate
```

### Migrations Structure

#### Wallets Table

- `id`: Unique identifier for the wallet.
- `wallet_id`: Unique String identifier for the wallet.
- `walletable_id`: The ID of the wallet owner (user or model).
- `walletable_type`: The type of the wallet owner (morph relation).
- `balance`: The balance of the wallet.
- `created_at`: Timestamp for wallet creation.
- `updated_at`: Timestamp for last update.

#### Wallet Transfers Table

- `id`: Unique identifier for the transfer.
- `from_wallet_id`: ID of the wallet from which funds are transferred.
- `to_wallet_id`: ID of the wallet to which funds are transferred.
- `amount`: Amount transferred.
- `created_at`: Timestamp for the transfer creation.
- `updated_at`: Timestamp for last update.

## Publishing Assets

To publish the models and migrations, run:

```bash
php artisan vendor:publish --provider="algeriany\wallet\WalletServiceProvider" --tag=models
php artisan vendor:publish --provider="algeriany\wallet\WalletServiceProvider" --tag=migrations
```

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
