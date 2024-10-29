<?php require 'db-connect.php'?>
<?php
import requests
import json

Lowest_price = input("最低価格 ----> ")
Highest_price = input("最高価格 ----> ")
item_name = input('キーワード-->')

appid = "Client ID"
url = 'https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid={}&price_from={}&price_to={}&query={}&results=100'.format(appid, Lowest_price, Highest_price, item_name)
call = requests.get(url)
res_dict = json.loads(call.content)
count = len(res_dict['hits'])

for i in range(count):
   print("商品名：", res_dict['hits'][i]['name'])
   print("説明：", res_dict['hits'][i]['description'])
   print("価格：", res_dict['hits'][i]['price'])
   print("商品コード：", res_dict['hits'][i]['code'])
   print("JANコード：", res_dict['hits'][i]['janCode'])
   print("商品URL", res_dict['hits'][i]['url'])

?>