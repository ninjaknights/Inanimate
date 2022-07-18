<?php

namespace ninjaknights\Inanimate;

use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandPermissions;
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
use pocketmine\network\mcpe\protocol\types\PlayerPermissions;
use pocketmine\network\mcpe\protocol\UpdateAbilitiesPacket;
use pocketmine\player\Player;
use pocketmine\Server;
use Ramsey\Uuid\Uuid;

class Inanimate
{

    public const type = [
        "PLAYER" => "Human",
        "NPC" => EntityIds::NPC,
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
     * @param Location $location
     * @param Skin $skin
     * @param string $name
     * @param Player[] $players
     */
    public function summonPlayer(Location $location, Skin $skin, string $name, array $players): void
    {
        $position = $location->asPosition();
        $uuid = Uuid::uuid4();
        $id = Entity::nextRuntimeId();

        $entry = new PlayerListEntry();
        $entry->uuid = $uuid;
        $entry->actorUniqueId = $id;
        $sas = new SkinAdapterSingleton();
        $entry->skinData = $sas->get()->toSkinData($skin);
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
        $addPlayerPacket->username = "";
        $addPlayerPacket->yaw = $location->yaw;
        $addPlayerPacket->pitch = $location->pitch;
        $addPlayerPacket->headYaw = $location->yaw;
        $addPlayerPacket->position = $position;
        $addPlayerPacket->metadata = [
            EntityMetadataProperties::NAMETAG => new StringMetadataProperty($name),
            EntityMetadataProperties::FLAGS => new LongMetadataProperty(1 << EntityMetadataFlags::IMMOBILE ^ 1 << EntityMetadataFlags::ADMIRING),
            EntityMetadataFlags::ALWAYS_SHOW_NAMETAG => new ByteMetadataProperty(1),
            EntityMetadataProperties::SCALE => new FloatMetadataProperty("1")
        ];
        $updateAbPacket = UpdateAbilitiesPacket::create(CommandPermissions::NORMAL, PlayerPermissions::MEMBER, $id, []);
        $addPlayerPacket->abilitiesPacket = $updateAbPacket;

        $playerListRemovePacket = new PlayerListPacket();
        $playerListRemovePacket->entries[] = $entry;
        $playerListRemovePacket->type = PlayerListPacket::TYPE_REMOVE;

        Server::getInstance()->broadcastPackets($players, [$playerListAddPacket, $addPlayerPacket, $playerListRemovePacket]);
    }

    /**
     * @param Location $location
     * @param string $type
     * @param string $name
     * @param Player[] $players
     */
    public function summonMob(Location $location, string $type, string $name, array $players): void
    {
        $position = $location->asPosition();
        $id = Entity::nextRuntimeId();

        $pk = new AddActorPacket();
        $pk->actorRuntimeId = $id;
        $pk->actorUniqueId = $id;
        $pk->attributes = $this->getAttributes();
        $pk->type = self::type[$type];
        $pk->pitch = $location->pitch;
        $pk->yaw = $location->yaw;
        $pk->headYaw = $location->yaw;
        $pk->position = $position;
        $pk->metadata = [
            EntityMetadataProperties::NAMETAG => new StringMetadataProperty($name),
            EntityMetadataProperties::FLAGS => new LongMetadataProperty(1 << EntityMetadataFlags::IMMOBILE),
            EntityMetadataProperties::ALWAYS_SHOW_NAMETAG => new ByteMetadataProperty(1),
            EntityMetadataProperties::HEALTH => new IntMetadataProperty(3),
            EntityMetadataProperties::SCALE => new FloatMetadataProperty(1)];
        Server::getInstance()->broadcastPackets($players, [$pk]);
    }

    protected function getAttributes(): array
    {
        return [new \pocketmine\network\mcpe\protocol\types\entity\Attribute(Attribute::HEALTH, 0, 3, 3, 3)];
    }

}