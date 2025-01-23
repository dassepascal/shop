<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $professionnal
 * @property string $civility
 * @property string|null $name
 * @property string|null $firstname
 * @property string|null $company
 * @property string $address
 * @property string|null $addressbis
 * @property string|null $bp
 * @property string $postal
 * @property string $city
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $country_id
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereBp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereProfessionnal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAddress {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $price
 * @property int $country_id
 * @property int $range_id
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colissimo whereRangeId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperColissimo {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $tax
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderAddress> $order_addresses
 * @property-read int|null $order_addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Range> $ranges
 * @property-read int|null $ranges_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereTax($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCountry {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $reference
 * @property string $shipping
 * @property string $total
 * @property string $tax
 * @property string $payment
 * @property string|null $purchase_order
 * @property int $pick
 * @property int|null $invoice_id
 * @property string|null $invoice_number
 * @property int $state_id
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read float $ht
 * @property-read string $payment_text
 * @property-read float $total_order
 * @property-read float $tva
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Payment|null $payment_infos
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\State $state
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePick($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePurchaseOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrder {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $facturation
 * @property int $professionnal
 * @property string $civility
 * @property string|null $name
 * @property string|null $firstname
 * @property string|null $company
 * @property string $address
 * @property string|null $addressbis
 * @property string|null $bp
 * @property string $postal
 * @property string $city
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property int $country_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereBp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereFacturation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereProfessionnal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrderAddress {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $total_price_gross
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereTotalPriceGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrderProduct {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTitle($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPage {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $payment_id
 * @property int $order_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPayment {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $weight
 * @property int $active
 * @property int $quantity
 * @property int $quantity_alert
 * @property string|null $image
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantityAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWeight($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProduct {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $max
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Range newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Range newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Range query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Range whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Range whereMax($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRange {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $holder
 * @property string $email
 * @property string $bic
 * @property string $iban
 * @property string $bank
 * @property string $bank_address
 * @property string $phone
 * @property string $facebook
 * @property string $home
 * @property string $home_infos
 * @property string $home_shipping
 * @property int $invoice
 * @property int $card
 * @property int $transfer
 * @property int $check
 * @property int $mandat
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Database\Factories\ShopFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereBankAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHomeInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereHomeShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereMandat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shop whereTransfer($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperShop {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property int $indice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereIndice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereSlug($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperState {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $firstname
 * @property string $email
 * @property int $newsletter
 * @property int $admin
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNewsletter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

