#安牛听问诊活动

##前台报名阶段：
用户通过提交用户信息进行报名
报名信息记录包含：
        姓名，
        电话，
        籍贯，
        民族，
        血型，
        病史，
        家族病史，
        咨询方向
        openid，(带上用户的openid)
记录openid的方法
####openid获取
通过调用现有的exchange来获取用户信息，并存储，获取openid存入报名记录表(获取openid方法同七夕活动获取openid方法一致)
###
###

###通过一个接口来记录用户信息
####接口请求地址：http://192.168.0.189/net_sindcorp_anniutingwenzhen/web/anniu/default/create
####接口请求方式：get
####接口数据结构格式:json格式
####接口请求参数
####必须参数：姓名，咨询方向，手机号
####可选参数：民族，年龄，血型，病史，家族病史
####接口返回结果举例

````php
//请求方式错误
{
    "code": 1,
    "desc": "请求方式错误"
}
//数据结构不完整
{
    "code": 1,
    "desc": {
        "username": [
            "姓名不能为空"
        ],
        "phone": [
            "电话不能为空"
        ],
        "consultdirection": [
            "咨询方向不能为空"
        ],
        "openid": [
            "微信号已经存在不能重复使用"
        ]
    }
}
//手机号存在
{
    "code": 1,
    "desc": {
        "phone": [
            "电话已经存在不能重复使用"
        ]
    }
}
//请求成功
{
    "code": 0,
    "desc": "添加成功"
}
````
##前台问诊阶段
####通过接口返回数据
###通过一个接口来记录用户信息，每个组中对应的用户以及组信息
####接口请求地址：http://192.168.0.189/net_sindcorp_anniutingwenzhen/web/anniu/list
####接口请求方式：get
####接口数据结构格式:json格式
####接口返回结果举例
数据包含所有分组对应的人员，以及分组对应的问诊时间,返回的结果数据如下
````
[
    {
        "group_id": "2",
        "group_name": "组一",
        "start_at": "1501707600",
        "end_at": "1503642600",
        "created_at": "1504174240",
        "updated_at": "1504174386",
        "user_list": [
            {
                "id": "2",
                "group_id": "2",
                "user_id": "2",
                "created_at": "1504233932",
                "updated_at": "1504233932",
                "user": {
                    "id": "2",
                    "username": "黎明",
                    "nation": "汉族",
                    "phone": "19811526232",
                    "age": "12",
                    "bloodtype": "A",
                    "medicalhistory": "cwas",
                    "familymedicalhistory": "家族病史",
                    "consultdirection": "咨询方向",
                    "openid": "o_P7SwLw3vgSa9dhkgHMDiaDskqk",
                    "created_at": "1504169200"
                }
            }
        ]
    },
    {
        "group_id": "3",
        "group_name": "组二",
        "start_at": "0",
        "end_at": "0",
        "created_at": "0",
        "updated_at": "0",
        "user_list": [
            {
                "id": "4",
                "group_id": "3",
                "user_id": "3",
                "created_at": "0",
                "updated_at": "0",
                "user": {
                    "id": "3",
                    "username": "李宁",
                    "nation": "",
                    "phone": "0",
                    "age": "1",
                    "bloodtype": "",
                    "medicalhistory": "",
                    "familymedicalhistory": "",
                    "consultdirection": "",
                    "openid": "",
                    "created_at": "0"
                }
            },
            {
                "id": "5",
                "group_id": "3",
                "user_id": "4",
                "created_at": "0",
                "updated_at": "0",
                "user_list": {
                    "id": "4",
                    "username": "王五",
                    "nation": "",
                    "phone": "0",
                    "age": "1",
                    "bloodtype": "",
                    "medicalhistory": "",
                    "familymedicalhistory": "",
                    "consultdirection": "",
                    "openid": "",
                    "created_at": "0"
                }
            }
        ]
    }
]
````
##用户进入小程序，获取登录用的openid
####接口请求地址：http://192.168.0.189/net_sindcorp_anniutingwenzhen/web/anniu/identify
####接口请求方式：get
####接口数据结构格式:json格式
####接口请求参数
####必须参数：appid, secret, code, grant_type, encryptedData, iv
####接口返回结果举例

````php

//openid获取失败
{
    "code": 10023,
    "errMsg": {
       "失败"
    }
}
//openid获取成功
{
    "code": 0,
    "openid": oZJcc0d01K7fCz9TSxKePnGpQX2Q
}
````





###筛选用户
从当前报名用户记录表中筛选粉丝(人工进行筛选)

###对用户进行分组，每组问诊时间确定
###通过后台来进行管理

##后台设计
#####分组设计管理
分组表创建，表中记录字段包含(分组名称，问诊开始时间，问诊结束时间)，管理员在后台可以进行问诊的分组添加

####给用户分组
创建用户和分组的关联表，表中记录(用户id，分组id)，管理员在后台进行用户对应的分组分配

