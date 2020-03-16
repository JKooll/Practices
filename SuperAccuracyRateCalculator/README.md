# Super Accuracy Rate Calculator（超级汇率计算器）
超级汇率计算器是一款基于mpvue开发的微信小程序。这个微信小程序集成实时汇率换算和计算器两种功能，不需要切换计算器应用也可以进行简单运算并显示实施汇率。这个小程序支持世界上大多数货币的汇率换算。

## 运行项目
1. 运行开发模式
```
npm run dev
```
2. 打开[微信开发者工具](https://developers.weixin.qq.com/miniprogram/dev/devtools/devtools.html)，导入小程序

## 参考资源
- [mpvue.com](http://mpvue.com/)

## ToDo
- 使用云函数，实现第三方API调用
这个小程序在获取国家列表的时候，会调用第三方API，但是微信小程序不允许直接调用第三方API，因此需要通过服务器来调用，微信提供的云服务开发可以实现这一点。