# plugins
## 我们来搞个插件
 - Config 配置文件读取，结合自己的项目容器使用
```
# 设置配置文件绝对路径
Config::getInstance()->parser('config_path');
# 文件名.配置key1.配置key2 用‘.’调用下一层的key
Config::getInstance()->get('key');
```