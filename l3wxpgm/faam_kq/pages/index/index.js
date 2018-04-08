//index.js
//获取应用实例
const app = getApp()
Page({
  data: {
    //motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
 

  bindButtonTap: function () {
    // 允许从相机和相册扫码
    wx.scanCode({
      success: (respScanCode) => {

        //获得位置信息
        wx.getLocation({
          type: 'wgs84',
          success: function (respGetLocation) {
            var latitude = (respGetLocation.latitude)*1000000
            var longitude = (respGetLocation.longitude)*1000000

            // var latitude = 31248986
            // var longitude = 121615234     ///////////////////////////

            var codeType = 'QRCODE_KQ'
            var scanCode = respScanCode.result

            
            wx.getUserInfo({
              success: function (res) {
                var userInfo = res.userInfo
                var nickName = userInfo.nickName
                console.log(nickName)
                //发起网络请求
                wx.request({
                  url: 'https://h5.aiqiworld.com/xhzn/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',    //爱启云
                  //url: 'http://www.hkrob.com/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',  //小慧云
                  //url: 'http://127.0.0.1/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',      //本地
                  data: {
                    codeType: codeType, //考勤二维码
                    scanCode: scanCode,
                    latitude: latitude,
                    longitude: longitude,
                    nickName: nickName,
                    phone: ''
                  },
                  method: "POST",
                  header: {
                    'content-type': 'application/json' // 默认值
                    //"content-type": "application/x-www-form-urlencoded"
                  },
                  success: function (wxResp) {

                    if (wxResp.data.message == '请输入手机号'){
                      wx.navigateTo({
                        url: '../logs/logs?1=1'+"&nickName=" + nickName + '&latitude=' + latitude + '&longitude=' + longitude + '&codeType=' + codeType + '&scanCode=' + scanCode
                      })
                      wx.showToast({
                        title: wxResp.data.message,
                        icon: 'succes',
                        duration: 2000,
                        mask: true
                      })

                    }
                    else{
                      wx.showToast({
                        title: wxResp.data.message,
                        icon: 'succes',
                        duration: 2000,
                        mask: true
                      })
                    }

                    
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
              }
            }) //wx.getUserInfo
          }
        })//wx.getLocation
      }
    })//wx.scanCode
  },


  onLoad: function () {
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse){
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  }
})
