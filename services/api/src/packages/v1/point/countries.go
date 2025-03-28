package point

type Country string

const (
	ALBANIA              Country = "Albania"
	ANGOLA               Country = "Angola"
	ARGENTINA            Country = "Argentina"
	AUSTRIA              Country = "Austria"
	AUSTRALIA            Country = "Australia"
	BOSNIA               Country = "Bosnia"
	BELGIUM              Country = "Belgium"
	BURKINA_FASO         Country = "Burkina Faso"
	BULGARIA             Country = "Bulgaria"
	BURUNDI              Country = "Burundi"
	BOLIVIA              Country = "Bolivia"
	BRAZIL               Country = "Brazil"
	BOTSWANA             Country = "Botswana"
	BELARUS              Country = "Belarus"
	CANADA               Country = "Canada"
	CONGO_KINSHASA       Country = "Congo (Kinshasa)"
	SWITZERLAND          Country = "Switzerland"
	CHILE                Country = "Chile"
	CHINA                Country = "China"
	COLOMBIA             Country = "Colombia"
	COSTA_RICA           Country = "Costa Rica"
	CUBA                 Country = "Cuba"
	CYPRUS               Country = "Cyprus"
	CZECH_REPUBLIC       Country = "Czech Republic"
	GERMANY              Country = "Germany"
	DENMARK              Country = "Denmark"
	DOMINICAN_REPUBLIC   Country = "Dominican Republic"
	ALGERIA              Country = "Algeria"
	ECUADOR              Country = "Ecuador"
	SPAIN                Country = "Spain"
	ESTONIA              Country = "Estonia"
	ETHIOPIA             Country = "Ethiopia"
	FINLAND              Country = "Finland"
	FRANCE               Country = "France"
	UNITED_KINGDOM       Country = "United Kingdom"
	GABON                Country = "Gabon"
	GEORGIA              Country = "Georgia"
	GHANA                Country = "Ghana"
	GREECE               Country = "Greece"
	GUATEMALA            Country = "Guatemala"
	HUNGARY              Country = "Hungary"
	INDONESIA            Country = "Indonesia"
	INDIA                Country = "India"
	IRELAND              Country = "Ireland"
	IRAN                 Country = "Iran"
	ICELAND              Country = "Iceland"
	ISRAEL               Country = "Israel"
	ITALY                Country = "Italy"
	IVORY_COAST          Country = "Ivory Coast"
	JAPAN                Country = "Japan"
	KAZAKHSTAN           Country = "Kazakhstan"
	KENYA                Country = "Kenya"
	KUWAIT               Country = "Kuwait"
	LATVIA               Country = "Latvia"
	LEBANON              Country = "Lebanon"
	LIBYA                Country = "Libya"
	LITHUANIA            Country = "Lithuania"
	LUXEMBOURG           Country = "Luxembourg"
	MADAGASCAR           Country = "Madagascar"
	MALAYSIA             Country = "Malaysia"
	MALI                 Country = "Mali"
	MEXICO               Country = "Mexico"
	MOLDOVA              Country = "Moldova"
	MONACO               Country = "Monaco"
	MONTENEGRO           Country = "Montenegro"
	MOROCCO              Country = "Morocco"
	MOZAMBIQUE           Country = "Mozambique"
	NAMIBIA              Country = "Namibia"
	NETHERLANDS          Country = "Netherlands"
	NEW_ZEALAND          Country = "New Zealand"
	NICARAGUA            Country = "Nicaragua"
	NIGER                Country = "Niger"
	NIGERIA              Country = "Nigeria"
	NORTH_MACEDONIA      Country = "North Macedonia"
	NORWAY               Country = "Norway"
	OMAN                 Country = "Oman"
	PAKISTAN             Country = "Pakistan"
	PANAMA               Country = "Panama"
	PARAGUAY             Country = "Paraguay"
	PERU                 Country = "Peru"
	PHILIPPINES          Country = "Philippines"
	POLAND               Country = "Poland"
	PORTUGAL             Country = "Portugal"
	QATAR                Country = "Qatar"
	ROMANIA              Country = "Romania"
	RUSSIA               Country = "Russia"
	RWANDA               Country = "Rwanda"
	SAUDI_ARABIA         Country = "Saudi Arabia"
	SENEGAL              Country = "Senegal"
	SERBIA               Country = "Serbia"
	SINGAPORE            Country = "Singapore"
	SLOVAKIA             Country = "Slovakia"
	SLOVENIA             Country = "Slovenia"
	SOMALIA              Country = "Somalia"
	SOUTH_AFRICA         Country = "South Africa"
	SOUTH_KOREA          Country = "South Korea"
	SUDAN                Country = "Sudan"
	SWEDEN               Country = "Sweden"
	SYRIA                Country = "Syria"
	TAJIKISTAN           Country = "Tajikistan"
	TANZANIA             Country = "Tanzania"
	THAILAND             Country = "Thailand"
	TUNISIA              Country = "Tunisia"
	TURKEY               Country = "Turkey"
	UKRAINE              Country = "Ukraine"
	UNITED_ARAB_EMIRATES Country = "United Arab Emirates"
	UNITED_STATES        Country = "United States"
	UZBEKISTAN           Country = "Uzbekistan"
	VENEZUELA            Country = "Venezuela"
	VIETNAM              Country = "Vietnam"
	YEMEN                Country = "Yemen"
	ZAMBIA               Country = "Zambia"
	ZIMBABWE             Country = "Zimbabwe"
)

func ToCountry(c string) Country {
	return Country(c)
}

func (c Country) Label() string {
	switch c {
	case ALBANIA:
		return "آلبانی"
	case ANGOLA:
		return "آنگولا"
	case ARGENTINA:
		return "آرژانتین"
	case AUSTRIA:
		return "اتریش"
	case AUSTRALIA:
		return "استرالیا"
	case BOSNIA:
		return "بوسنی"
	case BELGIUM:
		return "بلژیک"
	case BURKINA_FASO:
		return "بورکینافاسو"
	case BULGARIA:
		return "بلغارستان"
	case BURUNDI:
		return "بوروندی"
	case BOLIVIA:
		return "بولیوی"
	case BRAZIL:
		return "برزیل"
	case BOTSWANA:
		return "بوتسوانا"
	case BELARUS:
		return "بلاروس"
	case CANADA:
		return "کانادا"
	case CONGO_KINSHASA:
		return "کنگو (کینشازا)"
	case SWITZERLAND:
		return "سوئیس"
	case CHILE:
		return "شیلی"
	case CHINA:
		return "چین"
	case COLOMBIA:
		return "کلمبیا"
	case COSTA_RICA:
		return "کاستاریکا"
	case CUBA:
		return "کوبا"
	case CYPRUS:
		return "قبرس"
	case CZECH_REPUBLIC:
		return "جمهوری چک"
	case GERMANY:
		return "آلمان"
	case DENMARK:
		return "دانمارک"
	case DOMINICAN_REPUBLIC:
		return "جمهوری دومینیکن"
	case ALGERIA:
		return "الجزایر"
	case ECUADOR:
		return "اکوادور"
	case SPAIN:
		return "اسپانیا"
	case ESTONIA:
		return "استونی"
	case ETHIOPIA:
		return "اتیوپی"
	case FINLAND:
		return "فنلاند"
	case FRANCE:
		return "فرانسه"
	case UNITED_KINGDOM:
		return "بریتانیا"
	case GABON:
		return "گابن"
	case GEORGIA:
		return "گرجستان"
	case GHANA:
		return "غنا"
	case GREECE:
		return "یونان"
	case GUATEMALA:
		return "گواتمالا"
	case HUNGARY:
		return "مجارستان"
	case INDONESIA:
		return "اندونزی"
	case INDIA:
		return "هند"
	case IRELAND:
		return "ایرلند"
	case IRAN:
		return "ایران"
	case ICELAND:
		return "ایسلند"
	case ISRAEL:
		return "اسرائیل"
	case ITALY:
		return "ایتالیا"
	case IVORY_COAST:
		return "ساحل عاج"
	case JAPAN:
		return "ژاپن"
	case KAZAKHSTAN:
		return "قزاقستان"
	case KENYA:
		return "کنیا"
	case KUWAIT:
		return "کویت"
	case LATVIA:
		return "لتونی"
	case LEBANON:
		return "لبنان"
	case LIBYA:
		return "لیبی"
	case LITHUANIA:
		return "لیتوانی"
	case LUXEMBOURG:
		return "لوکزامبورگ"
	case MADAGASCAR:
		return "ماداگاسکار"
	case MALAYSIA:
		return "مالزی"
	case MALI:
		return "مالی"
	case MEXICO:
		return "مکزیک"
	case MOLDOVA:
		return "مولداوی"
	case MONACO:
		return "موناکو"
	case MONTENEGRO:
		return "مونته‌نگرو"
	case MOROCCO:
		return "مراکش"
	case MOZAMBIQUE:
		return "موزامبیک"
	case NAMIBIA:
		return "نامیبیا"
	case NETHERLANDS:
		return "هلند"
	case NEW_ZEALAND:
		return "نیوزلند"
	case NICARAGUA:
		return "نیکاراگوئه"
	case NIGER:
		return "نیجر"
	case NIGERIA:
		return "نیجریه"
	case NORTH_MACEDONIA:
		return "مقدونیه شمالی"
	case NORWAY:
		return "نروژ"
	case OMAN:
		return "عمان"
	case PAKISTAN:
		return "پاکستان"
	case PANAMA:
		return "پاناما"
	case PARAGUAY:
		return "پاراگوئه"
	case PERU:
		return "پرو"
	case PHILIPPINES:
		return "فیلیپین"
	case POLAND:
		return "لهستان"
	case PORTUGAL:
		return "پرتغال"
	case QATAR:
		return "قطر"
	case ROMANIA:
		return "رومانی"
	case RUSSIA:
		return "روسیه"
	case RWANDA:
		return "رواندا"
	case SAUDI_ARABIA:
		return "عربستان سعودی"
	case SENEGAL:
		return "سنگال"
	case SERBIA:
		return "صربستان"
	case SINGAPORE:
		return "سنگاپور"
	case SLOVAKIA:
		return "اسلواکی"
	case SLOVENIA:
		return "اسلوونی"
	case SOMALIA:
		return "سومالی"
	case SOUTH_AFRICA:
		return "آفریقای جنوبی"
	case SOUTH_KOREA:
		return "کره جنوبی"
	case SUDAN:
		return "سودان"
	case SWEDEN:
		return "سوئد"
	case SYRIA:
		return "سوریه"
	case TAJIKISTAN:
		return "تاجیکستان"
	case TANZANIA:
		return "تانزانیا"
	case THAILAND:
		return "تایلند"
	case TUNISIA:
		return "تونس"
	case TURKEY:
		return "ترکیه"
	case UKRAINE:
		return "اوکراین"
	case UNITED_ARAB_EMIRATES:
		return "امارات"
	case UNITED_STATES:
		return "ایالات متحده"
	case UZBEKISTAN:
		return "ازبکستان"
	case VENEZUELA:
		return "ونزوئلا"
	case VIETNAM:
		return "ویتنام"
	case YEMEN:
		return "یمن"
	case ZAMBIA:
		return "زامبیا"
	case ZIMBABWE:
		return "زیمبابوه"
	default:
		return "نامشخص"
	}
}
