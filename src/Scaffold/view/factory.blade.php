<script type="text/x-template" id="tttFactory">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Factory</h3>
        </caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th>Field</th>
            <th>Type</th>
            <th>Method</th>
            <th>Parameters</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in factory.field.list">
            <td><button v-on:click="remove(field)" class="btn btn-danger" type="button">X</button></td>
            <td>@brace('field.name')</td>
            <td>
                <select v-model="field.type" class="form-control">
                    <option value="raw">Raw</option>
                    <option value="property">Property</option>
                    <option value="method">Method</option>
                </select>
            </td>
            <td>
                <div v-if="'raw' == field.type">
                    <input v-model="field.raw" class="form-control" type="text">
                </div>
                <div v-else class="form-inline">
                    <label><input v-model="field.unique" type="checkbox"> Unique</label>
                    <select v-show="'method' == field.type" v-model="field.method" class="form-control">
                        <option value="name">name</option>
                        <option value="firstName">firstName</option>
                        <option value="title">title</option>
                        <option value="creditCardNumber">creditCardNumber</option>
                        <option value="iban">iban</option>
                        <option value="words">words</option>
                        <option value="sentence">sentence</option>
                        <option value="sentences">sentences</option>
                        <option value="paragraph">paragraph</option>
                        <option value="paragraphs">paragraphs</option>
                        <option value="text">text</option>
                        <option value="realText">realText</option>
                        <option value="password">password</option>
                        <option value="slug">slug</option>
                        <option value="amPm">amPm</option>
                        <option value="date">date</option>
                        <option value="dayOfMonth">dayOfMonth</option>
                        <option value="dayOfWeek">dayOfWeek</option>
                        <option value="iso8601">iso8601</option>
                        <option value="month">month</option>
                        <option value="monthName">monthName</option>
                        <option value="time">time</option>
                        <option value="unixTime">unixTime</option>
                        <option value="year">year</option>
                        <option value="dateTime">dateTime</option>
                        <option value="dateTimeAd">dateTimeAd</option>
                        <option value="dateTimeBetween">dateTimeBetween</option>
                        <option value="dateTimeInInterval">dateTimeInInterval</option>
                        <option value="dateTimeThisCentury">dateTimeThisCentury</option>
                        <option value="dateTimeThisDecade">dateTimeThisDecade</option>
                        <option value="dateTimeThisYear">dateTimeThisYear</option>
                        <option value="dateTimeThisMonth">dateTimeThisMonth</option>
                        <option value="boolean">boolean</option>
                        <option value="randomNumber">randomNumber</option>
                        <option value="randomKey">randomKey</option>
                        <option value="numberBetween">numberBetween</option>
                        <option value="randomFloat">randomFloat</option>
                        <option value="randomElement">randomElement</option>
                        <option value="randomElements">randomElements</option>
                        <option value="shuffle">shuffle</option>
                        <option value="shuffleArray">shuffleArray</option>
                        <option value="shuffleString">shuffleString</option>
                        <option value="numerify">numerify</option>
                        <option value="lexify">lexify</option>
                        <option value="bothify">bothify</option>
                        <option value="asciify">asciify</option>
                        <option value="regexify">regexify</option>
                        <option value="toLower">toLower</option>
                        <option value="toUpper">toUpper</option>
                        <option value="optional">optional</option>
                        <option value="unique">unique</option>
                        <option value="valid">valid</option>
                        <option value="biasedNumberBetween">biasedNumberBetween</option>
                        <option value="file">file</option>
                        <option value="imageUrl">imageUrl</option>
                        <option value="image">image</option>
                        <option value="randomHtml">randomHtml</option>
                    </select>
                    <select v-show="'property' == field.type" v-model="field.property" class="form-control">
                        <option value="name">name</option>
                        <option value="firstName">firstName</option>
                        <option value="firstNameMale">firstNameMale</option>
                        <option value="firstNameFemale">firstNameFemale</option>
                        <option value="lastName">lastName</option>
                        <option value="title">title</option>
                        <option value="titleMale">titleMale</option>
                        <option value="titleFemale">titleFemale</option>
                        <option value="citySuffix">citySuffix</option>
                        <option value="streetSuffix">streetSuffix</option>
                        <option value="buildingNumber">buildingNumber</option>
                        <option value="city">city</option>
                        <option value="streetName">streetName</option>
                        <option value="streetAddress">streetAddress</option>
                        <option value="postcode">postcode</option>
                        <option value="address">address</option>
                        <option value="country">country</option>
                        <option value="latitude">latitude</option>
                        <option value="longitude">longitude</option>
                        <option value="ean13">ean13</option>
                        <option value="ean8">ean8</option>
                        <option value="isbn13">isbn13</option>
                        <option value="isbn10">isbn10</option>
                        <option value="phoneNumber">phoneNumber</option>
                        <option value="company">company</option>
                        <option value="companySuffix">companySuffix</option>
                        <option value="jobTitle">jobTitle</option>
                        <option value="creditCardType">creditCardType</option>
                        <option value="creditCardNumber">creditCardNumber</option>
                        <option value="creditCardExpirationDate">creditCardExpirationDate</option>
                        <option value="creditCardExpirationDateString">creditCardExpirationDateString</option>
                        <option value="creditCardDetails">creditCardDetails</option>
                        <option value="bankAccountNumber">bankAccountNumber</option>
                        <option value="swiftBicNumber">swiftBicNumber</option>
                        <option value="vat">vat</option>
                        <option value="word">word</option>
                        <option value="words">words</option>
                        <option value="sentence">sentence</option>
                        <option value="sentences">sentences</option>
                        <option value="paragraph">paragraph</option>
                        <option value="paragraphs">paragraphs</option>
                        <option value="text">text</option>
                        <option value="email">email</option>
                        <option value="safeEmail">safeEmail</option>
                        <option value="freeEmail">freeEmail</option>
                        <option value="companyEmail">companyEmail</option>
                        <option value="freeEmailDomain">freeEmailDomain</option>
                        <option value="safeEmailDomain">safeEmailDomain</option>
                        <option value="userName">userName</option>
                        <option value="password">password</option>
                        <option value="domainName">domainName</option>
                        <option value="domainWord">domainWord</option>
                        <option value="tld">tld</option>
                        <option value="url">url</option>
                        <option value="slug">slug</option>
                        <option value="ipv4">ipv4</option>
                        <option value="ipv6">ipv6</option>
                        <option value="localIpv4">localIpv4</option>
                        <option value="macAddress">macAddress</option>
                        <option value="unixTime">unixTime</option>
                        <option value="dateTime">dateTime</option>
                        <option value="dateTimeAD">dateTimeAD</option>
                        <option value="iso8601">iso8601</option>
                        <option value="dateTimeThisCentury">dateTimeThisCentury</option>
                        <option value="dateTimeThisDecade">dateTimeThisDecade</option>
                        <option value="dateTimeThisYear">dateTimeThisYear</option>
                        <option value="dateTimeThisMonth">dateTimeThisMonth</option>
                        <option value="amPm">amPm</option>
                        <option value="dayOfMonth">dayOfMonth</option>
                        <option value="dayOfWeek">dayOfWeek</option>
                        <option value="month">month</option>
                        <option value="monthName">monthName</option>
                        <option value="year">year</option>
                        <option value="century">century</option>
                        <option value="timezone">timezone</option>
                        <option value="md5">md5</option>
                        <option value="sha1">sha1</option>
                        <option value="sha256">sha256</option>
                        <option value="locale">locale</option>
                        <option value="countryCode">countryCode</option>
                        <option value="countryISOAlpha3">countryISOAlpha3</option>
                        <option value="languageCode">languageCode</option>
                        <option value="currencyCode">currencyCode</option>
                        <option value="boolean">boolean</option>
                        <option value="randomDigit">randomDigit</option>
                        <option value="randomDigitNotNull">randomDigitNotNull</option>
                        <option value="randomLetter">randomLetter</option>
                        <option value="randomAscii">randomAscii</option>
                        <option value="macProcessor">macProcessor</option>
                        <option value="linuxProcessor">linuxProcessor</option>
                        <option value="userAgent">userAgent</option>
                        <option value="chrome">chrome</option>
                        <option value="firefox">firefox</option>
                        <option value="safari">safari</option>
                        <option value="opera">opera</option>
                        <option value="internetExplorer">internetExplorer</option>
                        <option value="windowsPlatformToken">windowsPlatformToken</option>
                        <option value="macPlatformToken">macPlatformToken</option>
                        <option value="linuxPlatformToken">linuxPlatformToken</option>
                        <option value="uuid">uuid</option>
                        <option value="mimeType">mimeType</option>
                        <option value="fileExtension">fileExtension</option>
                        <option value="hexColor">hexColor</option>
                        <option value="safeHexColor">safeHexColor</option>
                        <option value="rgbColor">rgbColor</option>
                        <option value="rgbColorAsArray">rgbColorAsArray</option>
                        <option value="rgbCssColor">rgbCssColor</option>
                        <option value="safeColorName">safeColorName</option>
                        <option value="colorName">colorName</option>
                    </select>
                </div>
            </td>
            <td><input v-model="field.parameters" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td><button v-on:click="factory.update()" class="btn btn-primary" type="button">All</button></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-factory', {
        template: '#tttFactory',
        props: ['factory'],
        methods: {
            remove: function (field) {
                if (confirm('Are you sure?')) {
                    this.factory.field.remove(field);
                }
            }
        }
    });

</script>
