# Silverstripe Automatic Machine Learning Page Tagging


## Synopsis


## Requirements 
*  SilverStripe 4+
*  PHP 7+


## Installation
### Composer
`composer require chewyou/silverstripe-automatic-page-tagging`

You may need to add the repository to the `repositories` list in composer.json
and add 

`"chewyou/silverstripe-automatic-page-tagging": "dev-master"` 

manually. Then run `composer update`

```json
"repositories": 
    [
        {
            "type": "vcs",
            "url": "https://github.com/chewyou/silverstripe-automatic-page-tagging.git"
        }
    ],
```

## Configuration
In the sites config.yml file, add database column names to a `content_to_train` config line.
This will be the content that is sent to the API to be used to train/untrain and classify pages.  
Functions may need to be created to get Elemental Content saved into a database column.  

eg.  
```yaml
Chewyou\AutoPageTagging\PageExtension:
  content_to_train: 'Title,BannerText,Content,Intro'
```  

Create uClassify account.  
Get READ and WRITE API keys.  
Get username.  
Create a Classifier for the Site. Remember the name of it.  
In the CMS Settings, under the Automatic Tagging Settings tab, fill in the values mentioned. 


## Usage


## Future work

