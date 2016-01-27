用途：为前端提供操作防DDOS服务数据库的相关接口
-------------------

此接口使用php编写，部署在webinternal角色的机器上，使用的域名为antiddos.test.com



提供的接口：
-----------

1,/antiddos/insert
添加应用（默认开启ddos防火墙，域名状态也正常）

    GET参数：
    appname 应用名
    accesskey 应用的ak

    返回信息：
    成功：{"code":0,"data":null}
    失败：{"code":1,"message":"原始的error信息"}

2,/antiddos/search
查看应用的ddos防火墙相关信息，返回应用的service_status，domain_status和ak信息

    GET参数：
    appname 应用名

    返回信息：
    成功：{"code":0,"data":[{"accesskey":"123456","service_status":"1","domain_status":"1"}]}
    失败：{"code":1,"message":"原始的error信息"}

3,/antiddos/updateServiceStatus
关闭/开启应用的ddos防火墙

    GET参数：
    appname 应用名
    service_status ddos防火墙是否开启的状态，0表示关闭，1表示开启

    返回信息：
    成功：{"code":0,"data":null}
    失败：{"code":1,"message":"原始的error信息"}

4,/antiddos/updateDomainStatus
关闭/开启应用的域名解析服务。如果这个应用解析服务关闭，则被解析到黑洞127.0.0.1(会有程序来扫这些应用看是否还有攻击，从而判断是否要把应用解析到正常状态)
    
    GET参数：
    appname 应用名
    domain_status 此应用的域名状态是否正常，0表示被解析到黑洞，1表示正常解析

    返回信息：
    成功：{"code":0,"data":null}
    失败：{"code":1,"message":"原始的error信息"}

5,/antiddos/delete
删除一个应用的ddos防火墙所有信息（如果删除一个不存在的应用，也返回成功）

    GET参数：
    appname 应用名

    返回信息：
    成功：{"code":0,"data":null}
    失败：{"code":1,"message":"原始的error信息"}


备注:
1,数据库字段相关信息
appname:应用名
accesskey：应用的ak
service_status：标识ddos防火墙是否开启
domain_status：表示此应用是否被解析到黑洞
update_timestamp：此记录插入的当前时间
