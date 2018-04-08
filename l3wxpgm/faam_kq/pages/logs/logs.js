//logs.js

var nk = ''
var latitude = ''
var longitude = ''
var codeType = ''
var scanCode = ''

Page({
  data:{
    nick:''
  },
  onLoad:function(mesg){
    nk = mesg.nickName
    latitude = mesg.latitude
    longitude = mesg.longitude
    codeType = mesg.codeType
    scanCode = mesg.scanCode

    this.setData({
      // nick: nickname
    })
  },
  formSubmit: function (e) {
    console.log('手机号为：', e.detail.value)
    console.log(nk)
    console.log(latitude)
    console.log(longitude)
    console.log(codeType)
    console.log(scanCode)

    console.log('调用后台')
    wx.request({
      url: 'https://h5.aiqiworld.com/xhzn/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',    //爱启云
      //url: 'http://127.0.0.1/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',      //本地
      data: {
        nickName: nk,
        latitude: latitude,
        longitude: longitude,
        codeType: codeType,
        scanCode: scanCode,
        phone: e.detail.value.input
      },
      method: "POST",
      header: {
         'content-type': 'application/json' // 默认值
        //  "content-type": "application/x-www-form-urlencoded"
      },
      success: function (wxResp) {
        
        wx.navigateTo({
          url: '../index/index'
        })
        wx.showToast({
          title: wxResp.data.message,
          icon: 'succes',
          duration: 2000,
          mask: true
        })
      },
      fail: function (wxResp) {
        wx.showToast({
          title: "扫描失败",
          icon: 'succes',
          duration: 2000,
          mask: true
        })
      }
    })//wx.request
  },
  formReset: function () {
    console.log('reset')
  }
})
