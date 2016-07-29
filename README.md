# twote API v2

This is the new **API** for [WhiteWhale Studios' twote](https://t.whitewhale.studio).

### Documentation:

`/account` - Endoint:
- `/login` _POST_ of a **PersonModel** with `{"username":"test", "password":"test"}`
- `/save` _POST_ of a **PersonModel** with `{"user_id":1, "email":"test@domain.tld","language":"en"}`
- `/show` _GET_
- `/logout` _POST_

  
`/twote` - Endoint:
- `/save` _POST_ of a **TwoteModel** with `{"content":"This is a very awesome twote!"}`
- `/update` _POST_ of a **TwoteModel** with `{"twote_id":1, "content":"This is a even better twote!"}`
- `/delete` _DELETE_ of a **TwoteModel** with `{"twote_id":1}`

### Deployment:

- `master` - push to this branch => rollout to [Live Server](https://t.whitewhale.studio)
- `test` - push to this branch => [Beta Server](https://twote-beta.irwks.net)