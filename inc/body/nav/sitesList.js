importSites(
    
        { //https://www.nasdaq.com/market-activity/stocks/nakd/short-interest
          //https://highshortinterest.com/
          //https://finviz.com/screener.ashx
          //https://iborrowdesk.com/report/AMC
          //https://csimarket.com/stocks/single_growth_rates.php?code=AAPL&rev
          'csi-market':{
            'id':'csi-market',
            'name':'csimarket',
            'domain':'csimarket.com',
            'sub':'http://',
            'rss':'/stocks/single_growth_rates.php?code=*V*&rev',
            'cmd':['rev>','revenue:']
          },'i-borrow-desk':{
            'id':'i-borrow-desk',
            'name':'IBorrowDesk',
            'domain':'iborrowdesk.com',
            'sub':'http://',
            'rss':'/report/',
            'cmd':['ibd>','borrow:']
          },'finance-yahoo-com':{
            'id':'finance-yahoo-com',
            'name':'Yahoo Finance',
            'domain':'finance.yahoo.com',
            'sub':'http://',
            'rss':'/quote/',
            'cmd':['yf>','yfinance:']
          },
          'short-squeeze-com':{
            'id':'short-squeeze-com',
            'name':'Short Squeeze dot com',
            'domain':'shortsqueeze.com/',
            'sub':'http://',
            'rss':'?symbol=',
            'cmd':['ss>','squeeze:']
          },
          'crypto-fear-or-greed':{
            'id':'crypto-fear-or-greed',
            'name':'Crypto Fear or Greed',
            'domain':'alternative.me/crypto/fear-and-greed-index/',
            'sub':'http://',
            'rss':'',
            'cmd':['cryptofog']
          },
          'cnn-fear-or-greed':{
            'id':'cnn-fear-or-greed',
            'name':'CNN Fear or Greed Index',
            'domain':'money.cnn.com/data/fear-and-greed/',
            'sub':'http://',
            'rss':'',
            'cmd':['cnnfog']
          },
          'shiller-pe-ratio':{
            'id':'shiller-pe-ratio',
            'name':'Shiller PE Ratio',
            'domain':'www.multpl.com/shiller-pe',
            'sub':'http://',
            'rss':'',
            'cmd':['shillerpe']
          },
          'stock-heat-map':{
            'id':'stock-heat-map',
            'name':'Stock Heat Map',
            'domain':'finviz.com/map.ashx?t=sec_all',
            'sub':'http://',
            'rss':'',
            'cmd':['stockheat']
          },
          'wsb-ticker-sentiment':{
            'id':'wsb-ticker-sentiment',
            'name':'WSB Ticker Sentiment ',
            'domain':'swaggystocks.com/dashboard/wallstreetbets/ticker-sentiment',
            'sub':'http://',
            'rss':'',
            'cmd':['wsbsent']
          },
          '13F-heat-map-whales':{
            'id':'13F-heat-map-whales',
            'name':'The 13F Heat Map ',
            'domain':'whalewisdom.com/report/heat_map?heat_map_id=3',
            'sub':'http://',
            'rss':'',
            'cmd':['stockwhales']
          },
          'finra-otc-transperancy-data':{
            'id':'finra-otc-transperancy-data',
            'name':'FINRA OTC Transperancy Data',
            'domain':'otctransparency.finra.org/otctransparency/OtcIssueData',
            'sub':'http://',
            'rss':'',
            'cmd':['otcfin']
          },
          'fail-to-deliver':{
          'id':'fail-to-deliver',
          'name':'SEC Report FTD',
          'domain':'sec.report/fails.php',
          'sub':'http://',
          'rss':'?tc=',
          'cmd':['ftd>']
        },
        'marketwatch-short-list':{
          'id':'marketwatch-short-list',
          'name':'MarketWatch Short List',
          'domain':'marketwatch.com',
          'sub':'http://www.',
          'rss':'/tools/screener/short-interest',
          'cmd':['mwshorts.']
        },
        'google':{
          'id':'google',
          'name':'Google Search',
          'domain':'google.com',
          'sub':'http://www.',
          'rss':'/search?q=',
          'cmd':['google:','g>']
      },'Fintel':{
        'id':'fintel',
        'name':'fintel',
        'domain':'fintel.io',
        'sub':'http://',
        'rss':'/ss/us/',
        'cmd':['fintel:','fin>','shorts:']
      },'Trading Alpha':{
        'id':'tradingalpha',
        'name':'Alpha',
        'domain':'seekingalpha.com',
        'sub':'http://www.',
        'rss':'/symbol/',
        'cmd':['a>','alpha:']
      },
      'yahoo':{
        'id':'yahoo',
        'name':'Yahoo Search',
        'domain':'yahoo.com',
        'sub':'http://search.',
        'rss':'/search?p=',
        'cmd':['yahoo:','y>']
      },
      'bing':{
        'id':'bing',
        'name':'Bing Search',
        'domain':'bing.com',
        'sub':'http://www.',
        'rss':'/search?q=',
        'cmd':['bing:','b>']
      },
      'udemy':{
        'id':'udemy',
        'name':'Udemy Courses',
        'domain':'udemy.com',
        'sub':'http://www.',
        'rss':'/home/my-courses/search/?q=',
        'cmd':['udemy:','u>']
      },
      'youtube':{
        'id':'youtube',
        'name':'YouTube',
        'domain':'youtube.com',
        'sub':'http://www.',
        'rss':'/results?search_query=',
        'cmd':['youtube:','yt>']
      },
      'duckduckgo':{
        'id':'duckduckgo',
        'name':'Duck Duck Go',
        'domain':'duckduckgo.com',
        'sub':'http://www.',
        'rss':'/?q=',
        'cmd':['duckduckgo:','ddg>']
      },
      'googletranslate':{
        'id':'googletranslate',
        'name':'Google Translate',
        'domain':'translate.google.com/',
        'sub':'http://',
        'rss':'',
        'vars':[['op','translate'],'sl','tl','text'],
        'cmd':['translate:','t>']
      },
      'robinhood':{
        'id':'robinhood',
        'name':'Robinhood',
        'domain':'www.robinhood.com',
        'sub':'http://',
        'rss':'',
        'vars':[],
        'cmd':['stocks','r>']
      },
      'facebook':{
        'id':'facebook',
        'name':'Facebook',
        'domain':'www.facebook.com',
        'sub':'http://',
        'cmd':['facebook','fb']
      },
      'takelessons':{
        'id':'takelessons',
        'name':'Takelessons',
        'domain':'takelessons.com/profile/crtu2ptsnc3s',
        'sub':'http://',
        'cmd':['takelessons','tl','classes']
      },
      'checkpoint':{
        'id':'checkpoint',
        'name':'Check Point',
        'domain':'threatmap.checkpoint.com/',
        'sub':'http://',
        'cmd':['hackmap','hack']
      },
      'discord':{
        'id':'discord',
        'name':'Discord',
        'domain':'discord.com/channels/@me',
        'sub':'http://',
        'cmd':['discord','dd']
      },'IPO calendar':{
        'id':'ipocal',
        'name':'IPO Calendar',
        'domain':'marketwatch.com/tools/ipo-calendar',
        'sub':'http://www.',
        'cmd':['ipo','ipo calendar']
      }
    }
)