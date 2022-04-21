## 流服务基础组件

用于构建流服务端及客户端

### 运行依赖

- php: ^8.1
- [loner/reactor][1]: ^1.0

### 安装

```shell
composer require loner/stream
```

不推荐直接安装，可选择升级组件

### 升级组件

* 无连接状态的流服务组件，详见【 [loner/stream-stateless](https://github.com/shen-da/stream-stateless) 】
* 有连接状态的流服务组件，详见【 [loner/stream-stateful](https://github.com/shen-da/stream-stateful) 】

### 组件功能

* 事件轮询反应器，详见【 [loner/reactor][1] 】


* 基础服务端：Loner\Stream\Server\Server

    ```php
    use Loner\Reactor\ReactorInterface;
    use Loner\Stream\Exception\ServerCreatedException;
    use Loner\Stream\Protocol\ProtocolInterface;
    use Loner\Stream\Server\Server;
    
    /** @var Server $server 基础服务端 */
    
    /** @var ReactorInterface $reactor 事件轮询反应器 */
    $reactor = $server->reactor;
    
    /**
     * 设置应用层协议，默认无
     * @var ProtocolInterface $protocol 应用层协议
     */
    $server->setProtocol($protocol);
    
    // 返回传输层协议类型
    $server->transport();
    // 返回监听地址，格式：【 主机名:端口号 】或【 文件路径 】
    $server->getTarget();
    // 返回详细监听地址，格式：【 传输层协议类型://监听地址 】
    $server->getSocketAddress();
    
    /**
     * 监听网络
     * @throws ServerCreatedException
     */
    $server->listen();
    // 移除网络监听
    $server->unListen();
    
    // 启动服务器（开启事件反应器轮询），内部自发调用 $server->listen()
    $server->start();
    // 停止服务器（破坏事件反应器轮询），内部自发调用 $server->unListen()
    $server->stop();
    ```

* 基础客户端：Loner\Stream\Client\Client

    ```php
    use Loner\Reactor\ReactorInterface;
    use Loner\Stream\Client\Client;
    use Loner\Stream\Protocol\ProtocolInterface;
    
    /** @var Client $client 基础客户端 */
    
    /** @var ReactorInterface $reactor 事件轮询反应器 */
    $reactor = $client->reactor;
    
    /**
     * 设置应用层协议，默认无
     * @var ProtocolInterface $protocol 应用层协议
     */
    $client->setProtocol($protocol);
    
    // 返回传输层协议类型
    $client->transport();
    // 返回监听地址，格式：【 主机名:端口号 】或【 文件路径 】
    $client->getTarget();
    // 返回详细监听地址，格式：【 传输层协议类型://监听地址 】
    $client->getSocketAddress();
    
    // 开始（或继续）监听接收数据
    $client->resumeReceive();
    // 停止（或暂停）监听接收数据
    $client->pauseReceive();
    
    // 监听网络，正常情况下会自发调用 $client->resumeReceive()
    $client->listen();
    ```

* 网络地址 IP、PORT

  ```php
  use Loner\Stream\Network\{Ip, Port};
  
  /** @var string $networkAddress 网络地址 */
  
  // 获取 IP
  $ip = Ip::get($networkAddress);
  
  // 判断是否 IPv4 网络
  $isIPv4 = Ip::isV4($networkAddress);
  // 判断是否 IPv6 网络
  $isIPv6 = Ip::isV6($networkAddress);
  
  // 获取端口号
  $port = Port::get($networkAddress);
  ```

* 通信消息

    ```php
    /** @var string $package 完整包 */
    /** @var Stringable $message 消息 */
    
    // 1. 服务端和客户端通信默认不含应用层协议，每当收到通信数据，就会触发消息事件，将接收数据视作完整包
    //      这时候消息事件回调中的消息，其实是接收到的字符串数据
    // 2. 若设置应用层协议，则根据协议，从接收到的通信（一次或多次）数据中解析出完整的包，转化成消息，同样触发消息事件
    //      这时候消息事件回调中的消息，是实现了 Stringable 接口的消息实体
    
    // 消息字符串表示形式为其完整数据包
    $package = (string)$message;
    ```

* 应用层协议：Loner\Stream\Protocol\ProtocolInterface

    ```php
    use Loner\Stream\Exception\DecodedException;
    use Loner\Stream\Message\{FrameMessage, TextMessage};
    use Loner\Stream\Protocol\{ProtocolInterface, TextProtocol, FrameProtocol};
    
    /** @var ProtocolInterface $protocol */
    
    /**
     * 尝试解析包长度，未完成则返回 null
     * @var string $buffer 接收到的缓冲数据
     */
    $protocol->input($buffer);
    
    /**
     * 将完整的数据包解码为消息
     * @throws DecodedException
     * @var Stringable $message 消息
     * @var string $package 完整的数据包
     */
    $message = $protocol->decode($package);
    
    // 消息字符串表示形式为其完整数据包
    $package = (string)$message;
    
    // 组件提供了两个简单协议，服务端和客户端通用
    
    // 1. 简单文本协议，完整包格式：消息体 + 换行
    /** @var TextProtocol $protocol */
    $protocol = new TextProtocol();
    
    /** @var TextMessage $message 基于简单文本协议的消息 */
    $package = "消息体\r\n";
    // $package = "消息体\n";
    $message = $protocol->decode($package);
    // 消息主体内容为：消息体
    $body = $message->body;
    
    // 2. 简单帧协议，完整包格式：头部（4字节，包含消息长度信息）+ 消息体
    /** @var FrameProtocol $protocol */
    $protocol = new FrameProtocol();
    
    /** @var FrameMessage $message 基于简单帧协议的消息 */
    $package = pack('N', 4 + strlen('消息体')) . '消息体';
    $message = $protocol->decode($package);
    // 消息主体内容为：消息体
    $body = $message->body;
    ```

补充说明：

* 自定义应用层协议对应的消息需实现 Stringable 接口，且其字符串表示形式须为其完整数据包
* 部分协议因请求和响应格式不同，要区分服务端和客户端，例如 http、websocket 协议

[1]:https://github.com/shen-da/reactor
