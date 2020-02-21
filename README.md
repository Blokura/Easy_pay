# 有更新！
2020.02版：https://github.com/Blokura/Epay
# 彩虹易支付介绍
彩虹易支付是某公司旗下的免签约支付产品，可以帮助站长一站式解决网站签约各种支付接口的难题，拥有支付宝、财付通、QQ钱包、微信支付等免签约支付功能，并有开发文档与SDK，可快速集成到站长的网站。

本项目是彩虹易支付平台的系统，需自行配备支付宝、微信、QQ、财付通的支付接口，可自定义费率，自带支付宝登录接口，支持微信公众号批量打款、支付宝单笔转账到支付宝接口，可快速批量处理提现。

# 食用方法
1.直接 Download 或者下载 release

2.丢到服务器上去,建议使用PHP5.6

3.在includes文件夹中修改config.php文件的数据库信息以及你网站的配置信息

4.数据库导入install.sql

5.请手动到以下目录修改自己的支付接口

QQ钱包：includes/qqpay/qpayMch.config.php
支付宝：includes/alipay/alipay.config.php
微信：includes/wxpay/WxPay.Config.php
财付通：includes/tenpay/tenpay.config.php

6.打开你的域名/admin 登录

7.Enjoy!

# 进阶设置
## QQ互联登录
修改includes/QC.conf.php中的appid，appkey和callback地址(https://你的域名/user/connect.php)

## 单笔转账至支付宝功能设置
修改includes/f2fpay/config.php中的内容，需企业支付宝签约单笔转账至支付宝功能才可以使用
