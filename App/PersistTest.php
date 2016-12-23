<?php

namespace rekitae\App;

/**
 * Interface IPersist
 */
/**
 * Interface IPersist
 * @package rekitae\App
 */
/**
 * Interface IPersist
 * @package rekitae\App
 */
interface IPersist
{
    /**
     * 지시자
     *
     * @var int[] An array of int objects.
     */
    const a = [5];

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string;

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function set(string $key, string $value);

    function flush();
}

/**
 * Interface IPersist2
 * @package rekitae\App
 */
interface IPersist2
{
    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string;

    public function set(string $key, string $value);

    function flush();
}

/**
 * Class RedisPersist
 * @package rekitae\App
 */
class RedisPersist implements IPersist
{
    public function get(string $key): string
    {
        echo 'redis get ', $key, PHP_EOL;
        return 'redis get';
    }

    public function set(string $key, string $value)
    {
        echo 'redis set ', $key, ' ', $value, PHP_EOL;
    }

    function flush()
    {
        echo 'not support', PHP_EOL;
    }
}

/**
 * Class MemcachedPersist
 * @package rekitae\App
 */
class MemcachedPersist implements IPersist
{
    public function get(string $key): string
    {
        echo 'memcached get ', $key, PHP_EOL;
        return 'memcached get';
    }

    function __sleep()
    {
        // TODO: Implement __sleep() method.
    }

    public function set(string $key, string $value)
    {
        echo 'memcached set ', $key, ' ', serialize($value), PHP_EOL;
    }

    function flush()
    {
        echo 'not support', PHP_EOL;
    }
}

/**
 * Class MemoryPersist
 * @package rekitae\App
 */
class MemoryPersist implements IPersist
{
    private $arr;

    function __construct()
    {
        $this->arr = new \stdClass;
    }

    public function get(string $key): string
    {
        echo 'memory get ', $key, PHP_EOL;
        return $this->arr->{$key} ?? null;
    }

    public function set(string $key, string $value)
    {
        echo 'memory set ', $key, ' ', $value, PHP_EOL;
        $this->arr->{$key} = $value;
    }

    function flush()
    {
        echo 'not support', PHP_EOL;
    }
}

/**
 * Class MyApp
 * @package rekitae\App
 * @author ktlee2
 */
class MyApp
{
    /**
     * 아이디
     * @var string
     */
    private $id;

    /**
     * 성명
     * @var string
     */
    private $name;

    /**
     * 나이
     * @var int
     */
    private $age;

    /**
     * 휴대전화번호
     * @var string
     */
    private $phone;

    /**
     * 영속층 인터페이스 클래스
     * @var IPersist
     */
    private $persist;

    /**
     * MyApp constructor.
     */
    function __construct()
    {
        //return $this;
    }

    /**
     * @param string $id
     */
    function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * 뭐 데이터를 셋팅 하는 건데요
     *
     * @author ktlee
     * @param string $id
     * @param string $name
     * @param int $age
     * @param string $phone
     * @return array
     */
    function setData(string $id, string $name, int $age, string $phone) : array
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->phone = $phone;
        return [];
    }

    /**
     * @return array
     */
    function getData()
    {
        return [$this->name, $this->age, $this->phone];
    }

    /**
     * @param IPersist $persist
     */
    public function setPersist(IPersist $persist)
    {
        /**
         * @todo DIP 제대로 처리 해야지
         */
        $this->persist = $persist;
    }

    /** asflksajflkjsadlfksad
     * @return IPersist
     */
    public function getPersist(): IPersist
    {
        return $this->persist;
    }

    /**
     *
     */
    public function load()
    {
        list($this->name, $this->age, $this->phone) = json_decode($this->getPersist()->get($this->id));
    }

    /**
     *
     */
    public function save()
    {
        $this->getPersist()->set($this->id, json_encode([$this->name, $this->age, $this->phone]));
    }
}

$redisPersist = new RedisPersist();
$memcachedPersist = new MemcachedPersist();
$memoryPersist = new MemoryPersist();

echo '----------------------------------- Memcached', PHP_EOL;
$app = new MyApp();
$app->setData('rekitae', 'kitae re', 36, '010-2673-0629');
$app->setPersist($memcachedPersist);
$app->save();
$app->load();

echo '----------------------------------- Memory', PHP_EOL;
$app = new MyApp();
$app->setData('rekitae', 'kitae re', 36, '010-2673-0629');
$app->setPersist($memoryPersist);
$app->save();

unSet($app);

echo '----------------------------------- Memory', PHP_EOL;
$app2 = new MyApp();
$app2->setPersist($memoryPersist);
$app2->setId('rekitae');
$app2->load();

print_r($app2->getData());

/**
 * # MyClass Documentation
 *
 *  Describes _how to use_ the class with some examples:
 * ```
 * // Create new instance
 * $obj = new MyClass();
 * $obj2 = new MyClass();
 * ```
 * HTML tags are properly escaped:
 * ```
 * <html><div></div></html>
 * ```
 * Steps:
 * - Step 1
 * - Step 2
 * - Step 3
 *
 * Steps2:
 * * Step 1
 * * Step 2
 * * Step 3
 *
 * **Note:** _Some important note._;
 */
class MyClass
{
    /**
     * 아이디
     * @var string
     */
    private $id;

    /**
     * 이름
     * @var string
     */
    protected $name;

    /**
     * 나이
     * @var int
     */
    public $age;

    /**
     * # 테스트 메소드
     *
     * 테스트 하려고 만든 메소드 입니다
     *
     * 중요점 1
     * - 'value'    : the string value of the token in the input string
     *
     * 중요점 2
     * - 'type'     : the type of the token (identifier, numeric, string, input parameter, none)
     * - 'position' : the position of the token in the input string

     * @param int $a 나이
     * @param string $b 성명
     * @param array $c 메타데이터
     * @return array [나이,성명,메타데이터]
     */
    public function func(int $a, string $b, array $c) : array
    {
        return [$a, $b, $c];
    }

    private function priFunc()
    {

    }

    protected function proFunc()
    {

    }
}

print_r((new MyClass())->func(1, 'b', ['c', 'd']));
