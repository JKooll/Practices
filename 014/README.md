##测试环境
本地测试使用的是windows版的workerman，部署在linux服务器上替换
成linux版的workerman
##sendClient和receiveClient绑定
receiveClient生成一个带有当前连接uid的sendClient链接，
该连接时绑定receiveClient的uid和sendClient的uid。
##Client uid
生成的每个Client实例，都要从Config中申请一个唯一uid
##Client请求返回数据格式
定义为json类型,必须包含一个action字段和dir{server | sendClient | receiveClient}字段，
用来区分行为,action方法必须有返回值当执行失败是返回false，否则返回true

{"action" : xxx, ...}
get_connection_uid

show_connection_uid

show_msg

show_orientation

##二维码生成
给每个二维码加上全局唯一编号，从config申请一个qid