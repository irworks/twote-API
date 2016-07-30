# twote API v2

This is the new **API** for [WhiteWhale Studios' twote](https://t.whitewhale.studio).

### Documentation:

**Important:** This API expects all HTTP Body data as *JSON Strings!*
**Always** send the following *HTTP Headers*. (Yes, they are named so ugly because HTTP Headers should be named like this. :( )

  `headers`:
- `Devicetype` => {ios, android, windows, toaster, my_cat}
- `Appversion` => {major_version (build_num)} ex. 1.3 (42)
- `Apiversion` => {2.0}
- `Bundleidentifier` => {tld.domain.appname} ex. (cloud.kitchenapps.twote-for-taoster)

### Endpoints:

`/account` - Endoint:
- `/login` _POST_ of a **PersonModel** with `{"username":"test", "password":"test"}`
- `/*user_id*` _PUT_ of a **PersonModel** with `{"user_id":1, "email":"test@domain.tld","language":"en"}`
- `/` _GET_
- `/logout` _POST_


`/twote` - Endoint:
- `/` _POST_ of a new **TwoteModel** with `{"content":"This is a very awesome twote!"}`
- `/*twote_id*` _PUT_ of a **TwoteModel** with `{"content":"This is an even better twote!"}`
- `/*twote_id*` _DELETE_ of a **TwoteModel**
- `/*twote_id*` _GET_ of a **TwoteModel**
- `/all` _GET_ of an array of **TwoteModels**

### Deployment:

- `master` - push to this branch => auto-deployment to [Live Server](https://t.whitewhale.studio)
- `test` - push to this branch => auto-deployment to [Beta Server](https://twote-beta.irwks.net)