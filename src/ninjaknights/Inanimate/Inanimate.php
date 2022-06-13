<?php

namespace ninjaknights\Inanimate;

use JsonException;
use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\LegacySkinAdapter;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\AdventureSettingsPacket;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\entity\ByteMetadataProperty;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\types\entity\FloatMetadataProperty;
use pocketmine\network\mcpe\protocol\types\entity\IntMetadataProperty;
use pocketmine\network\mcpe\protocol\types\entity\LongMetadataProperty;
use pocketmine\network\mcpe\protocol\types\entity\StringMetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use pocketmine\player\Player;
use Ramsey\Uuid\Uuid;

class Inanimate
{

    public const type = [
        "PLAYER" => "Human",
        "WITHER_SKELETON" => EntityIds::WITHER_SKELETON,
        "HUSK" => EntityIds::HUSK,
        "STRAY" => EntityIds::STRAY,
        "WITCH" => EntityIds::WITCH,
        "ZOMBIE_VILLAGER" => EntityIds::ZOMBIE_VILLAGER,
        "BLAZE" => EntityIds::BLAZE,
        "MAGMA_CUBE" => EntityIds::MAGMA_CUBE,
        "GHAST" => EntityIds::GHAST,
        "CAVE_SPIDER" => EntityIds::CAVE_SPIDER,
        "SILVERFISH" => EntityIds::SILVERFISH,
        "ENDERMAN" => EntityIds::ENDERMAN,
        "SLIME" => EntityIds::SLIME,
        "ZOMBIE_PIGMAN" => EntityIds::ZOMBIE_PIGMAN,
        "SPIDER" => EntityIds::SPIDER,
        "SKELETON" => EntityIds::SKELETON,
        "CREEPER" => EntityIds::CREEPER,
        "ZOMBIE" => EntityIds::ZOMBIE,
        "SKELETON_HORSE" => EntityIds::SKELETON_HORSE,
        "MULE" => EntityIds::MULE,
        "DONKEY" => EntityIds::DONKEY,
        "DOLPHIN" => EntityIds::DOLPHIN,
        "TROPICALFISH" => EntityIds::TROPICALFISH,
        "WOLF" => EntityIds::WOLF,
        "SQUID" => EntityIds::SQUID,
        "DROWNED" => EntityIds::DROWNED,
        "SHEEP" => EntityIds::SHEEP,
        "MOOSHROOM" => EntityIds::MOOSHROOM,
        "PANDA" => EntityIds::PANDA,
        "SALMON" => EntityIds::SALMON,
        "PIG" => EntityIds::PIG,
        "VILLAGER" => EntityIds::VILLAGER,
        "COD" => EntityIds::COD,
        "PUFFERFISH" => EntityIds::PUFFERFISH,
        "COW" => EntityIds::COW,
        "CHICKEN" => EntityIds::CHICKEN,
        "LLAMA" => EntityIds::LLAMA,
        "IRON_GOLEM" => EntityIds::IRON_GOLEM,
        "RABBIT" => EntityIds::RABBIT,
        "SNOW_GOLEM" => EntityIds::SNOW_GOLEM,
        "BAT" => EntityIds::BAT,
        "OCELOT" => EntityIds::OCELOT,
        "HORSE" => EntityIds::HORSE,
        "CAT" => EntityIds::CAT,
        "POLAR_BEAR" => EntityIds::POLAR_BEAR,
        "ZOMBIE_HORSE" => EntityIds::ZOMBIE_HORSE,
        "TURTLE" => EntityIds::TURTLE,
        "PARROT" => EntityIds::PARROT,
        "GUARDIAN" => EntityIds::GUARDIAN,
        "ELDER_GUARDIAN" => EntityIds::ELDER_GUARDIAN,
        "VINDICATOR" => EntityIds::VINDICATOR,
        "WITHER" => EntityIds::WITHER,
        "ENDER_DRAGON" => EntityIds::ENDER_DRAGON,
        "SHULKER" => EntityIds::SHULKER,
        "ENDERMITE" => EntityIds::ENDERMITE,
        "MINECART" => EntityIds::MINECART,
        "HOPPER_MINECART" => EntityIds::HOPPER_MINECART,
        "TNT_MINECART" => EntityIds::TNT_MINECART,
        "CHEST_MINECART" => EntityIds::CHEST_MINECART,
        "COMMAND_BLOCK_MINECART" => EntityIds::COMMAND_BLOCK_MINECART,
        "ARMOR_STAND" => EntityIds::ARMOR_STAND,
        "ITEM" => EntityIds::ITEM,
        "TNT" => EntityIds::TNT,
        "FALLING_BLOCK" => EntityIds::FALLING_BLOCK,
        "XP_BOTTLE" => EntityIds::XP_BOTTLE,
        "XP_ORB" => EntityIds::XP_ORB,
        "EYE_OF_ENDER_SIGNAL" => EntityIds::EYE_OF_ENDER_SIGNAL,
        "ENDER_CRYSTAL" => EntityIds::ENDER_CRYSTAL,
        "SHULKER_BULLET" => EntityIds::SHULKER_BULLET,
        "FISHING_HOOK" => EntityIds::FISHING_HOOK,
        "DRAGON_FIREBALL" => EntityIds::DRAGON_FIREBALL,
        "ARROW" => EntityIds::ARROW,
        "SNOWBALL" => EntityIds::SNOWBALL,
        "EGG" => EntityIds::EGG,
        //  "PAINTING" => EntityIds::PAINTING, wanna crash someone?
        "THROWN_TRIDENT" => EntityIds::THROWN_TRIDENT,
        "FIREBALL" => EntityIds::FIREBALL,
        "SPLASH_POTION" => EntityIds::SPLASH_POTION,
        "ENDER_PEARL" => EntityIds::ENDER_PEARL,
        "LEASH_KNOT" => EntityIds::LEASH_KNOT,
        "WITHER_SKULL" => EntityIds::WITHER_SKULL,
        "WITHER_SKULL_DANGEROUS" => EntityIds::WITHER_SKULL_DANGEROUS,
        "BOAT" => EntityIds::BOAT,
        "LIGHTNING_BOLT" => EntityIds::LIGHTNING_BOLT,
        "SMALL_FIREBALL" => EntityIds::SMALL_FIREBALL,
        "LLAMA_SPIT" => EntityIds::LLAMA_SPIT,
        "LINGERING_POTION" => EntityIds::LINGERING_POTION,
        "FIREWORKS_ROCKET" => EntityIds::FIREWORKS_ROCKET,
        "EVOCATION_ILLAGER" => EntityIds::EVOCATION_ILLAGER,
        "VEX" => EntityIds::VEX,
        "PHANTOM" => EntityIds::PHANTOM,
        "TRIPOD_CAMERA" => EntityIds::TRIPOD_CAMERA
    ];

    /**
     * @throws JsonException
     */
    public function summonPlayer(Player $player, string $name): void
    {
        $position = $player->getPosition();
        $uuid = Uuid::uuid4();
        $id = Entity::nextRuntimeId();

        $entry = new PlayerListEntry();
        $entry->uuid = $uuid;
        $entry->actorUniqueId = $id;
        $legacy = new LegacySkinAdapter();
        $entry->skinData = $legacy->toSkinData($player->getSkin());
        $entry->username = "";
        $entry->xboxUserId = "";

        $playerListAddPacket = new PlayerListPacket();
        $playerListAddPacket->entries[] = $entry;
        $playerListAddPacket->type = PlayerListPacket::TYPE_ADD;

        $addPlayerPacket = new AddPlayerPacket();
        $addPlayerPacket->gameMode = 0;
        $addPlayerPacket->uuid = $uuid;
        $addPlayerPacket->motion = new Vector3(0, 0, 0);
        $addPlayerPacket->item = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet(ItemFactory::air()));
        $addPlayerPacket->actorRuntimeId = $id;
        $addPlayerPacket->actorUniqueId = $id;
        $addPlayerPacket->username = "";
        $addPlayerPacket->yaw = $player->getLocation()->yaw;
        $addPlayerPacket->pitch = $player->getLocation()->pitch;
        $addPlayerPacket->headYaw = $this->correctHeadYaw($player->getLocation()->yaw);
        $adventurepk = new AdventureSettingsPacket();
        $adventurepk->targetActorUniqueId = $id;
        $addPlayerPacket->adventureSettingsPacket = $adventurepk;
        $addPlayerPacket->position = $position;
        $addPlayerPacket->metadata = [
            EntityMetadataProperties::NAMETAG => new StringMetadataProperty($name),
            EntityMetadataProperties::FLAGS => new LongMetadataProperty(1 << EntityMetadataFlags::IMMOBILE ^ 1 << EntityMetadataFlags::ADMIRING),
            EntityMetadataFlags::ALWAYS_SHOW_NAMETAG => new ByteMetadataProperty(1),
            EntityMetadataProperties::SCALE => new FloatMetadataProperty("1")
        ];

        $playerListRemovePacket = new PlayerListPacket();
        $playerListRemovePacket->entries[] = $entry;
        $playerListRemovePacket->type = PlayerListPacket::TYPE_REMOVE;

        $player->getServer()->broadcastPackets([$player], [$playerListAddPacket, $addPlayerPacket, $playerListRemovePacket]);
    }

    public function correctHeadYaw($yaw): int
    {
        if( 170 >= $yaw and $yaw >= 50){
            return 310 + $yaw;
        }elseif($yaw < 50){
            return 0;
        }elseif ($yaw > 170 and $yaw <= 310) {
            return $yaw + 50;
        }elseif ($yaw <= 310){
            return 0;
        }elseif ($yaw > 420 and $yaw <= 530){
            return $yaw - 50;
        }elseif ($yaw > 530 and $yaw <= 640){
            return $yaw + 50;
        }
        return $yaw;
    }

    public function summonMob(Player $player, string $type, string $name): void
    {
        $position = $player->getPosition();
        $id = Entity::nextRuntimeId();

        $pk = new AddActorPacket();
        $pk->actorRuntimeId = $id;
        $pk->actorUniqueId = $id;
        $pk->attributes = $this->getAttributes();
        $pk->type = self::type[$type];
        $pk->pitch = $player->getLocation()->pitch;
        $pk->yaw = $player->getLocation()->yaw;
        $pk->headYaw = $player->getLocation()->yaw;
        $pk->position = $position;
        $pk->metadata = [
            EntityMetadataProperties::NAMETAG => new StringMetadataProperty($name),
            EntityMetadataProperties::FLAGS => new LongMetadataProperty( 1 << EntityMetadataFlags::IMMOBILE),
            EntityMetadataProperties::ALWAYS_SHOW_NAMETAG =>new ByteMetadataProperty(1),
            EntityMetadataProperties::HEALTH => new IntMetadataProperty(3),
            EntityMetadataProperties::SCALE => new FloatMetadataProperty( 1)];
        $player->getNetworkSession()->sendDataPacket($pk);
    }

    protected function getAttributes() : array{
        return [ new \pocketmine\network\mcpe\protocol\types\entity\Attribute(Attribute::HEALTH, 0 ,3,3,3)];
    }
}