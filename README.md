# Drupal Meetups Twitterbot

A CLI application designed to help promote Drupal meetups and provide a central repository of meetup related tweets.

The tweets are limited by both username and hashtag. If an approved user posts a tweet that contains an approved hashtag, then the app will automatically retweet it. To see what the current filters are, see [config.php](https://github.com/opdavies/drupal-meetups-twitterbot/blob/master/config.php).

To make any suggestions to either (e.g. to suggest a new meetup or hashtag) please open an issue and submit a pull request. Any approved users found to be using the hashtag for non-relevant content will be removed. 

The account that this app posts to is [@drupal_meetups](https://twitter.com/drupal_meetups).

## Usage

- Run `php app.php fetch` to fetch the matching tweets and display them in a table.
- Run `php app.php run` to fetch the tweets and retweet them.

## Licence

MIT

## Author

- [Oliver Davies](https://www.oliverdavi.es) - PHP Developer
