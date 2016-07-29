# twote API v2

This is the new **API** for [WhiteWhale Studios' twote](https://t.whitewhale.studio).

### Documentation:

`/account` - Endoint:
- `/login` _POST_ of a **PersonModel** with `{"username":"test", "password":"test"}`
- `/save` _POST_ of a **PersonModel** with `{"user_id":1, "email":"test@domain.tld","language":"en"}`
- `/show` _GET_
- `/logout` _POST_